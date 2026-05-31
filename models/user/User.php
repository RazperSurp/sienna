<?php

namespace app\models\user;

use Yii;
use app\models\club\Club;
use yii\db\Query;

class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{

    private static $users = [
        '100' => [
            'id' => '100',
            'username' => 'admin',
            'password' => 'admin',
            'authKey' => 'test100key',
            'accessToken' => '100-token',
        ],
        '101' => [
            'id' => '101',
            'username' => 'demo',
            'password' => 'demo',
            'authKey' => 'test101key',
            'accessToken' => '101-token',
        ],
    ];


    public static function tableName()
    {
        return '{{%users}}';
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        $user = self::findOne($id);
        return  $user ? $user: null;
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        $user = self::findOne(['auth_token' => $token]);

        return $user ? $user : null;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        $user = self::findOne(['username' => $username]);

        return $user ? $user : null;
    }

    public static function findByEmail($email)
    {
        $user = self::findOne(['email' => $email]);

        return $user ? $user : null;
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_token;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public function generateAuthKey()
    {
        $this->auth_token = Yii::$app->security->generateRandomString();
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password , $this->password_hash);
    }

    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    public function getRole(){
        $roles = Yii::$app->authManager->getRolesByUser($this->id);
        if (empty($roles)) return null;
        
        $firstRole = reset($roles);
        return $firstRole->name;
    }

    public function changeRole($roleName){
        $authManager = Yii::$app->authManager;

        $role = $authManager->getRole($roleName);
        
        if(!$role){
            return false;
        }

        $authManager->revokeAll($this->id);

        return $authManager->assign($role , $this->id) != null;
    }

    public function changeClub($clubId){
        $this->club_id = $clubId;
        return $this->save(false);
    }

    public function getClub(){
        return $this->hasOne(Club::class, ['id' => 'club_id']);
    }


    public function getFullName(){
        return (new Query())->select(['full_name'])->from('user_fullname')->where(['id' => $this->id])->all()[0]['full_name'];
    }

    public static function findAlikeUserByFullName($fullName){
        $data = (new Query())
        ->select(['*', 'full_name AS text'])
        ->from('user_fullname')
        ->where(['like', 'full_name', $fullName . '%', false]) 
        ->limit(20)
        ->all();

        return array_values($data);
    }
}
