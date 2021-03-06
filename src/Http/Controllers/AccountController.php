<?php

namespace Sahakavatar\User\Http\Controllers;

use Illuminate\Contracts\Auth\Guard;
use Sahakavatar\Cms\Http\Controllers\Controller;
use Sahakavatar\User\Http\Requests\Account\ChangeRegistrationRequest;
use Sahakavatar\User\Http\Requests\Account\SaveAccountRequest;
use Sahakavatar\User\Repository\UserRepository;
use Sahakavatar\User\Services\AccountService;

/**
 * Class AccountController
 * @package Sahakavatar\User\Http\Controllers
 */
class AccountController extends Controller
{


    /**
     * @param Guard $auth
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIndex(
        Guard $auth
    )
    {
        $user = $auth->user();
        return view('users::account', compact('user'));
    }


    /**
     * @param UserRepository $userRepository
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getNotifications
    (
        UserRepository $userRepository
    )
    {
        $data = $userRepository->getAll();
        return view('users::notifications', $data);
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getEditProfile()
    {
        return view('users::edit_profile');
    }


    /**
     * @param ChangeRegistrationRequest $request
     * @param AccountService $accountService
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changeRegistration(
        ChangeRegistrationRequest $request,
        AccountService $accountService
    )
    {
        $requestData = $request->only('email', 'password');
        $accountService->changePassword($requestData);
        return redirect()->back()->with(
            [
                'flash' => [
                    'message' => trans('Password has been changed successfully.'),
                ]
            ]
        );
    }


    /**
     * @param SaveAccountRequest $request
     * @param AccountService $accountService
     * @return \Illuminate\Http\RedirectResponse
     */
    public function saveAccount(
        SaveAccountRequest $request,
        AccountService $accountService
    )
    {
        $requestData = $request->except('_token');
        $accountService->saveAccount($requestData);
        return redirect()->back()->with(
            [
                'flash' => [
                    'message' => trans('Account has been changed successfully.'),
                ]
            ]
        );
    }
}
