<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/18
 * Time: 下午3:59
 */

namespace Data\Common\Object;


use Core\DSXObject;

class FeedbackObject extends DSXObject
{
    protected $fields = array(
        'id'=>'',
        'uid'=>'',
        'username'=>'',
        'contact'=>'',
        'message'=>'',
        'dateline'=>''
    );

    private $id;
    private $uid;
    private $username;
    private $contact;
    private $message;
    private $dateline;

    /**
     * @param mixed $id
     * @return FeedbackObject
     */
    public function setId($id)
    {
        $this->id = $id;
        $this->fields['id'] = $id;
        return $this;
    }

    /**
     * @param mixed $uid
     * @return FeedbackObject
     */
    public function setUid($uid)
    {
        $this->uid = $uid;
        $this->fields['uid'] = $uid;
        return $this;
    }

    /**
     * @param mixed $username
     * @return FeedbackObject
     */
    public function setUsername($username)
    {
        $this->username = $username;
        $this->fields['username'] = $username;
        return $this;
    }

    /**
     * @param mixed $contact
     * @return FeedbackObject
     */
    public function setContact($contact)
    {
        $this->contact = $contact;
        $this->fields['contact'] = $contact;
        return $this;
    }

    /**
     * @param mixed $message
     * @return FeedbackObject
     */
    public function setMessage($message)
    {
        $this->message = $message;
        $this->fields['message'] = $message;
        return $this;
    }

    /**
     * @param mixed $dateline
     * @return FeedbackObject
     */
    public function setDateline($dateline)
    {
        $this->dateline = $dateline;
        $this->fields['dateline'] = $dateline;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getUid()
    {
        return $this->uid;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return mixed
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @return mixed
     */
    public function getDateline()
    {
        return $this->dateline;
    }
}