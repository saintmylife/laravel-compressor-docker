<?php

namespace App\Modules\Base\Domain;

use App\Modules\Common\Domain\Payload;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

abstract class BaseResponder
{
    protected $request;
    protected $response;
    protected $payload;

    public function __invoke(Payload $payload): Response
    {
        $this->payload = $payload;
        $method = $this->getMethodForPayload();
        $this->$method();
        return $this->response;
    }

    protected function found(): void
    {
        $this->response = response()->json([
            'status'    => true,
            'messages'  => 'Get Data Successfully !!',
            'data'      => $this->payload->getResult()['data']
        ]);
    }

    protected function created(): void
    {
        $this->response = response()->json([
            'status'    => true,
            'messages'  => 'Create succesfully !!',
            'data'      => $this->payload->getResult()['create']
        ]);
    }

    protected function updated(): void
    {
        $this->response = response()->json([
            'status'    => true,
            'messages'  => 'Update succesfully !!',
            'data'      => $this->payload->getResult()['data']
        ]);
    }

    protected function deleted(): void
    {
        $this->renderResult();
    }

    protected function notCreated(): void
    {
        $this->response = response()
            ->json([
                'status'    => true,
                'messages'  => 'Data Not Created'
            ], 501);
    }

    protected function notUpdated(): void
    {
        $this->response = response()
            ->json([
                'status'    => true,
                'messages'  => 'Data Not Updated'
            ], 501);
    }

    protected function notDeleted(): void
    {
        $this->response = response()
            ->json([
                'status'    => true,
                'messages'  => 'Data Not Deleted'
            ], 410);
    }

    protected function verified(): void
    {
        $this->response = response()
            ->json([
                'status'    => true,
                'messages'  => 'Success Verify Your Account'
            ]);
    }

    protected function alreadyVerified(): void
    {
        $this->response = response()
            ->json([
                'status'    => true,
                'messages'  => 'Your Account is Already Verified'
            ],501);
    }
    protected function resendVerified(): void
    {
        $this->response = response()
            ->json([
                'status'    => true,
                'data'      => $this->payload->getResult()['data'],
                'messages'  => 'Please Check Your Email to Verify Your Account'
            ]);
    }
    protected function verifiedFailed(): void
    {
        $this->response = response()
            ->json([
                'status'    => false,
                'messages'  => 'Invalid or Expired OTP Provided'
            ],401)
        ;
    }
    protected function notValid(): void
    {
        $this->response = response()
            ->json([
                'status'    => false,
                'messages'  => $this->payload->getResult()['messages'],
                'data'      => $this->payload->getResult()['data']
            ], 400);
    }

    protected function notFound(): void
    {
        $this->response = abort(
            response()->json([
                'status'    => false,
                'messages'  => 'ID : ' . $this->payload->getResult()['id'] . ' not found !!',
                'data'      => []
            ], 404)
        );
    }
    protected function notFoundParams(): void
    {
        $this->response = abort(
            response()->json([
                'status'    => false,
                'messages'  => 'Params : ' . $this->payload->getResult()['params'] . ' not found !!',
                'data'      => []
            ], 404)
        );
    }


    protected function emailNotFound(): void
    {
        $this->response = abort(
            response()->json([
                'status'    => false,
                'messages'  => 'Email : ' . $this->payload->getResult()['data']['email'] . ' not found !!',
                'data'      => []
            ], 404)
        );
    }

    protected function forgetPassword(): void
    {
        $this->response = abort(
            response()->json([
                'status'    => true,
                'data'      => $this->payload->getResult()['data'],
                'messages'  => 'Please Check Your Email to Reset Password for Your Account'
            ])
        );
    }

    protected function resetPasswordFailed(): void
    {
        $this->response = abort(
            response()->json([
                'status'    => false,
                'messages'  => 'Invalid Token'
            ], 400)
        );
    }

    protected function resetPasswordSuccess(): void
    {
        $this->response = abort(
            response()->json([
                'status'    => true,
                'messages'  => 'Your Password Has been Reseted.'
            ], 400)
        );
    }

    protected function changePasswordFailed(): void
    {
        $this->response = abort(
            response()->json([
                'status'    => false,
                'messages'  => 'Your Old Password is Incorect.'
            ],501)
        );
    }

    protected function changePasswordSuccess(): void
    {
        $this->response = abort(
            response()->json([
                'status'    => true,
                'messages'  => 'Your Password Has been Changed.'
            ])
        );
    }

    protected function error(): void
    {
        $e = $this->payload->getResult()['exception'];
        $this->response = abort(
            response()->json($e, 505)
        );
    }

    protected function unauthorized(): void
    {
        $this->response = abort(
            response()->json([
                'status'    => false,
                'messages'  => 'Unauthorized Access',
                'data'      => []
            ], 401)
        );
    }
    protected function forbidden(): void
    {
        $this->response = abort(
            response()->json([
                'status'    => false,
                'messages'  => 'Forbidden',
                'data'      => []
            ], 403)
        );
    }
    protected function custom(): void
    {
        $this->response = abort(
            response()->json([
                'status'    => false,
                'messages'  => $this->payload->getResult()['messages'],
            ],$this->payload->getResult()['response'])
        );
    }

    protected function renderResult(): void
    {
        $this->response = response()->json($this->payload->getResult());
    }

    protected function getMethodForPayload(): string
    {
        $method = Str::camel($this->payload->getStatus());
        return method_exists($this, $method) ? $method : 'notRecognized';
    }

    protected function notRecognized(): void
    {
        $domain_status = $this->payload->getStatus();
        $this->response = abort(501, sprintf('Unknown method (%s) for payload status: \'%s\'', Str::camel($domain_status), $domain_status));
    }
}
