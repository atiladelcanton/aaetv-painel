<?php


namespace App\ZenSolutions\Services;


use App\Mail\RegisterUser;
use App\ZenSolutions\Contracts\ServiceContract;
use App\ZenSolutions\Repositories\UserRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

/**
 * Class UserService
 *
 * @package App\ZenSolutions\Services
 * @version 1.0.0
 */
class UserService implements ServiceContract
{

    private $user;

    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }

    /**
     * @param string $column
     * @param string $orderColumn
     *
     * @return mixed
     */
    public function renderList(string $column = 'id', $orderColumn = 'DESC')
    {
        return $this->user->getAll();
    }

    /**
     * @param $id
     *
     * @return mixed
     * @throws Exception
     */
    public function renderEdit($id)
    {
        $user = $this->user->getById($id);

        if (is_null($user)) {
            throw new Exception(env('not_found'), 404);
        }
        return $user;
    }

    /**
     * @param int   $id
     * @param array $data
     *
     * @return mixed
     */
    public function buildUpdate(int $id, array $data)
    {
        if (isset($data['password'])) {
            if (!is_null($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            } else {
                unset($data['password']);
            }
        }


        $user = $this->user->update($id, $data);
    }

    /**
     * @param array $data
     *
     * @return mixed
     */
    public function buildInsert(array $data)
    {
        $no_crypt = $this->mapUserPassword($data);
        $data['password'] = Hash::make($no_crypt);
        $data['password_no_crype'] = $no_crypt;
        $user = $this->user->create($data);
        DB::table('role_user')->insert(['user_id' => $user->id, 'role_id' => $data['role_id']]);

        Mail::to($user->email)->send(new RegisterUser($user, $no_crypt));
    }

    /**
     * @param array $data
     *
     * @return string
     */
    private function mapUserPassword(array $data) : string
    {
        return $data['password'] = $this->password_generate(8);
    }

    function password_generate($chars) : string
    {
        $data = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcefghijklmnopqrstuvwxyz';
        return substr(str_shuffle($data), 0, $chars);
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function buildDelete($id)
    {
        return $this->user->delete($id);
    }
}
