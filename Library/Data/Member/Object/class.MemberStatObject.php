<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/18
 * Time: 下午2:53
 */

namespace Data\Member\Object;


use Core\DSXObject;

class MemberStatObject extends DSXObject
{
    protected $fields = array(
        'uid'=>'',
        'postnum'=>'',
        'commentnum'=>'',
        'albumnum'=>'',
        'photonum'=>'',
        'follower'=>'',
        'following'=>''
    );

    private $uid;
    private $postnum;
    private $commentnum;
    private $albumnum;
    private $photonum;
    private $follower;
    private $following;

    /**
     * @param mixed $uid
     * @return MemberStatObject
     */
    public function setUid($uid)
    {
        $this->uid = $uid;
        $this->fields['uid'] = $this;
        return $this;
    }

    /**
     * @param mixed $postnum
     * @return MemberStatObject
     */
    public function setPostnum($postnum)
    {
        $this->postnum = $postnum;
        $this->fields['postnum'] = $postnum;
        return $this;
    }

    /**
     * @param mixed $commentnum
     * @return MemberStatObject
     */
    public function setCommentnum($commentnum)
    {
        $this->commentnum = $commentnum;
        $this->fields['commentnum'] = $commentnum;
        return $this;
    }

    /**
     * @param mixed $albumnum
     * @return MemberStatObject
     */
    public function setAlbumnum($albumnum)
    {
        $this->albumnum = $albumnum;
        $this->fields['albumnum'] = $albumnum;
        return $this;
    }

    /**
     * @param mixed $photonum
     * @return MemberStatObject
     */
    public function setPhotonum($photonum)
    {
        $this->photonum = $photonum;
        $this->fields['photonum'] = $photonum;
        return $this;
    }

    /**
     * @param mixed $follower
     * @return MemberStatObject
     */
    public function setFollower($follower)
    {
        $this->follower = $follower;
        $this->fields['follower'] = $follower;
        return $this;
    }

    /**
     * @param mixed $following
     * @return MemberStatObject
     */
    public function setFollowing($following)
    {
        $this->following = $following;
        $this->fields['following'] = $following;
        return $this;
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
    public function getPostnum()
    {
        return $this->postnum;
    }

    /**
     * @return mixed
     */
    public function getCommentnum()
    {
        return $this->commentnum;
    }

    /**
     * @return mixed
     */
    public function getAlbumnum()
    {
        return $this->albumnum;
    }

    /**
     * @return mixed
     */
    public function getPhotonum()
    {
        return $this->photonum;
    }

    /**
     * @return mixed
     */
    public function getFollower()
    {
        return $this->follower;
    }

    /**
     * @return mixed
     */
    public function getFollowing()
    {
        return $this->following;
    }
}