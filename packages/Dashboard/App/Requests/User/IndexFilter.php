<?php

declare( strict_types = 1 );

namespace Packages\Dashboard\App\Requests\User;

use Illuminate\Database\Eloquent\Builder;
use Packages\Dashboard\App\Requests\BaseFilter;
use Packages\Dashboard\App\Models\User;

/**
 * Class IndexRequest
 *
 * @package  App\Modules\Auto
 *
 */
class IndexFilter extends BaseFilter
{
    /*
     * @return  bool
     */
    public function authorize(): bool
    {
        return true;
        //return can('');
    }

    /*
     * @return  array
     */
    public function rules(): array
    {
        $rules = parent::rules() + [
            'sort_attr' => [
                'nullable',
                'string',
                'in:' . implode(',', [
                    'id',
                    'email',
                    'username',
                    'created_at',
                    'role_id',
                    'ban_to',
                ]),
            ],
            'email' => [
                'nullable',
            ],
            'username' => [
                'nullable',
            ],
            'id' => [
                'nullable',
            ],
            'ban_to' => [
                'nullable',
            ],
            'is_ban' => [
                'nullable',
            ],
        ];

        return $rules;
    }

    /*
     * @return  Builder
     */
    public function getQueryBuilder() : Builder
    {
        $query = User::query()
                    ->selectRaw('
                        users.*,
                        roles.title AS role_title
                    ')
                    ->leftJoin('roles', 'users.role_id','roles.id');

        if ($this->id !== null) {
            $query->where("id", "like", "%{$this->id}%");
        }

        if ($this->email !== null) {
            $query->where("email", "like", "%{$this->email}%");
        }

        if ($this->username !== null) {
            $query->where("username", "like", "%{$this->username}%");
        }

        if ($this->role_id !== null) {
            $query->where("role_id", $this->role_id);
        }

        if ($this->is_ban == '1') {
            $query->whereRaw("(ban_to IS NOT NULL AND ban_to > NOW())");
        }

        if ($this->is_ban == '0') {
            $query->whereRaw("(ban_to IS NULL OR ban_to < NOW())");
        }

        return $query;
    }

    /*
     * @return  array
     */
    public function getData()
    {
        return $this->resolveData(function(User $row) {
            return [
                'id' => $row->id,
                'email' => $row->email,
                'image' => $row->getImageOrNull('image', '100x100'),
                'username' => $row->username,
                'created_at' => (string)$row->created_at,
                'role_id' => (string)$row->role_title,
                'ban_to' => (string)$row->ban_to,
                'is_ban' => $row->checkIsBan(),
            ];
        });
    }

}
