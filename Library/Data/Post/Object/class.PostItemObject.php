<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/18
 * Time: 下午1:45
 */

namespace Data\Post\Object;


use Core\DSXObject;

class PostItemObject extends DSXObject
{
    protected $fields = array(
        'aid'=>'',
        'uid'=>'',
        'username'=>'',
        'catid'=>'',
        'author'=>'',
        'type'=>'',
        'title'=>'',
        'alias'=>'',
        'summary'=>'',
        'image'=>'',
        'tags'=>'',
        'pubtime'=>'',
        'modified'=>'',
        'allowcomment'=>'',
        'collection_num'=>'',
        'comment_num'=>'',
        'view_num'=>'',
        'like_num'=>'',
        'status'=>'',
        'from'=>'',
        'fromurl'=>'',
        'contents'=>'',
        'price'=>''
    );

    private $aid;
    private $uid;
    private $username;
    private $catid;
    private $author;
    private $type;
    private $title;
    private $alias;
    private $summary;
    private $image;
    private $tags;
    private $pubtime;
    private $modified;
    private $allowcomment;
    private $collection_num;
    private $comment_num;
    private $view_num;
    private $like_num;
    private $status;
    private $from;
    private $fromurl;
    private $contents;
    private $price;

    /**
     * @param mixed $aid
     * @return PostItemObject
     */
    public function setAid($aid)
    {
        $this->aid = $aid;
        $this->fields['aid'] = $aid;
        return $this;
    }

    /**
     * @param mixed $uid
     * @return PostItemObject
     */
    public function setUid($uid)
    {
        $this->uid = $uid;
        $this->fields['uid'] = $uid;
        return $this;
    }

    /**
     * @param mixed $username
     * @return PostItemObject
     */
    public function setUsername($username)
    {
        $this->username = $username;
        $this->fields['username'] = $username;
        return $this;
    }

    /**
     * @param mixed $catid
     * @return PostItemObject
     */
    public function setCatid($catid)
    {
        $this->catid = $catid;
        $this->fields['catid'] = $catid;
        return $this;
    }

    /**
     * @param mixed $author
     * @return PostItemObject
     */
    public function setAuthor($author)
    {
        $this->author = $author;
        $this->fields['author'] = $author;
        return $this;
    }

    /**
     * @param mixed $type
     * @return PostItemObject
     */
    public function setType($type)
    {
        $this->type = $type;
        $this->fields['type'] = $type;
        return $this;
    }

    /**
     * @param mixed $title
     * @return PostItemObject
     */
    public function setTitle($title)
    {
        $this->title = $title;
        $this->fields['title'] = $title;
        return $this;
    }

    /**
     * @param mixed $alias
     * @return PostItemObject
     */
    public function setAlias($alias)
    {
        $this->alias = $alias;
        $this->fields['alias'] = $alias;
        return $this;
    }

    /**
     * @param mixed $summary
     * @return PostItemObject
     */
    public function setSummary($summary)
    {
        $this->summary = $summary;
        $this->fields['summary'] = $summary;
        return $this;
    }

    /**
     * @param mixed $image
     * @return PostItemObject
     */
    public function setImage($image)
    {
        $this->image = $image;
        $this->fields['image'] = $image;
        return $this;
    }

    /**
     * @param mixed $tags
     * @return PostItemObject
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
        $this->fields['tags'] = $tags;
        return $this;
    }

    /**
     * @param mixed $pubtime
     * @return PostItemObject
     */
    public function setPubtime($pubtime)
    {
        $this->pubtime = $pubtime;
        $this->fields['pubtime'] = $pubtime;
        return $this;
    }

    /**
     * @param mixed $modified
     * @return PostItemObject
     */
    public function setModified($modified)
    {
        $this->modified = $modified;
        $this->fields['modified'] = $modified;
        return $this;
    }

    /**
     * @param mixed $allowcomment
     * @return PostItemObject
     */
    public function setAllowcomment($allowcomment)
    {
        $this->allowcomment = $allowcomment;
        $this->fields['allowcomment'] = $allowcomment;
        return $this;
    }

    /**
     * @param mixed $collection_num
     * @return PostItemObject
     */
    public function setCollectionNum($collection_num)
    {
        $this->collection_num = $collection_num;
        $this->fields['collection_num'] = $collection_num;
        return $this;
    }

    /**
     * @param mixed $comment_num
     * @return PostItemObject
     */
    public function setCommentNum($comment_num)
    {
        $this->comment_num = $comment_num;
        $this->fields['comment_num'] = $comment_num;
        return $this;
    }

    /**
     * @param mixed $view_num
     * @return PostItemObject
     */
    public function setViewNum($view_num)
    {
        $this->view_num = $view_num;
        $this->fields['view_num'] = $view_num;
        return $this;
    }

    /**
     * @param mixed $like_num
     * @return PostItemObject
     */
    public function setLikeNum($like_num)
    {
        $this->like_num = $like_num;
        $this->fields['like_num'] = $like_num;
        return $this;
    }

    /**
     * @param mixed $status
     * @return PostItemObject
     */
    public function setStatus($status)
    {
        $this->status = $status;
        $this->fields['status'] = $status;
        return $this;
    }

    /**
     * @param mixed $from
     * @return PostItemObject
     */
    public function setFrom($from)
    {
        $this->from = $from;
        $this->fields['from'] = $from;
        return $this;
    }

    /**
     * @param mixed $fromurl
     * @return PostItemObject
     */
    public function setFromurl($fromurl)
    {
        $this->fromurl = $fromurl;
        $this->fields['fromurl'] = $fromurl;
        return $this;
    }

    /**
     * @param mixed $contents
     * @return PostItemObject
     */
    public function setContents($contents)
    {
        $this->contents = $contents;
        $this->fields['contents'] = $contents;
        return $this;
    }

    /**
     * @param mixed $price
     * @return PostItemObject
     */
    public function setPrice($price)
    {
        $this->price = $price;
        $this->fields['price'] = $price;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAid()
    {
        return $this->aid;
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
    public function getCatid()
    {
        return $this->catid;
    }

    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return mixed
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * @return mixed
     */
    public function getSummary()
    {
        return $this->summary;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @return mixed
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @return mixed
     */
    public function getPubtime()
    {
        return $this->pubtime;
    }

    /**
     * @return mixed
     */
    public function getModified()
    {
        return $this->modified;
    }

    /**
     * @return mixed
     */
    public function getAllowcomment()
    {
        return $this->allowcomment;
    }

    /**
     * @return mixed
     */
    public function getCollectionNum()
    {
        return $this->collection_num;
    }

    /**
     * @return mixed
     */
    public function getCommentNum()
    {
        return $this->comment_num;
    }

    /**
     * @return mixed
     */
    public function getViewNum()
    {
        return $this->view_num;
    }

    /**
     * @return mixed
     */
    public function getLikeNum()
    {
        return $this->like_num;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return mixed
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @return mixed
     */
    public function getFromurl()
    {
        return $this->fromurl;
    }

    /**
     * @return mixed
     */
    public function getContents()
    {
        return $this->contents;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }
}