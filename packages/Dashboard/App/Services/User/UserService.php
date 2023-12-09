<?php

/**
 * @package     Dashboard
 * @version     0.1.0
 * @author      LLC Studio <hello@digitalp.co>
 * @license     MIT
 * @copyright   2015, LLC
 * @link        https://digitalp.com
 */

namespace Packages\Dashboard\App\Services\User;

use Packages\Dashboard\App\Models\User;
use Packages\Dashboard\App\Exceptions\RolesException;
use Packages\Dashboard\App\Exceptions\UsersException;
use Packages\Dashboard\App\Services\Auth\AuthService;
use Packages\Dashboard\App\Services\Base\BaseService;
use Packages\Dashboard\App\Services\Role\RoleService;

class UserService extends BaseService
{
    /**
     * Get user by id.
     *
     * @param int $id
     *
     * @return User|null
     */
    public function getById($id)
    {
        return User::find($id);
    }

    /**
     * Create user.
     *
     * @param array $data
     *
     * @param bool $validate
     *
     * @return void
     * @throws RolesException
     * @throws \Packages\Dashboard\App\Exceptions\AuthenticationException
     * @throws \Packages\Dashboard\App\Exceptions\FormValidationException
     */
    public function create(array $data, $validate = true)
    {
        (new AuthService())->registerAndActivate($data, $validate);
    }

    /**
     * Update user.
     *
     * @param array $data
     * @param int   $id
     * @param bool  $validate
     *
     * @throws \Packages\Dashboard\App\Exceptions\FormValidationException
     * @throws \Packages\Dashboard\App\Exceptions\RolesException
     * @throws \Packages\Dashboard\App\Exceptions\UsersException
     */
    public function update(array $data, $id, $validate = true)
    {
        if (!$user = $this->getById($id)) {
            throw new UsersException('User could not be found.');
        }

        if ($user->email != $data['email']) {
            $this->rules['email'] = 'required|email|unique:users';
        } else {
            $this->rules['email'] = 'required|email';
        }

        if ($validate) {
            $this->validate($data);
        }

        Sentinel::update($user, $data);

        if (isset($data['role'])) {

            $roleService = new RoleService();

            if (!$role = $roleService->getBySlug($data['role'])) {
                throw new RolesException('Role could not be found.');
            }

            if (!$user->inRole($role)) {
                $role->users()
                     ->attach($user);
            }
        }

        $user->save();

        return;
    }

    /**
     * Delete user.
     *
     * @param int $id
     *
     * @throws \Packages\Dashboard\App\Exceptions\UsersException
     */
    public function delete($id)
    {
        if (!$user = $this->getById($id)) {
            throw new UsersException('User cannot be found.');
        }

        $user->delete();

        return;
    }
}
