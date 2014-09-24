<?php

namespace BishopB\Vfl;

class Discussion extends BaseModel
{
    // validation
    protected $rules = [
        'Type'              => 'max:10',
        'ForeignID'         => 'max:32',
        'CategoryID'        => 'required|exists:GDN_Category,CategoryID',
        'FirstCommentID'    => 'exists:GDN_Comment,CommentID',
        'LastCommentID'     => 'exists:GDN_Comment,CommentID',
        'Name'              => 'required|max:100',
        'Body'              => 'required',
        'Format'            => 'max:20',
        // 'Tags'              => none,
        'CountComments'     => 'integer|min:0',
        'CountBookmarks'    => 'integer|min:0',
        'CountViews'        => 'integer|min:0',
        'Closed'            => 'boolean',
        'Announce'          => 'boolean',
        'Sink'              => 'boolean',
        'DateLastComment'   => 'date',
        'LastCommentUserID' => 'exists:GDN_User,UserID',
        'Score'             => 'numeric',
        // 'Attributes'        => none,
        'RegardingID'       => 'integer',
    ];

    // auditing
    use AuditingTrait;
    public function getAuditors()
    {
        return [
            'InsertUserID', 'DateInserted', 'InsertIPAddress',
            'UpdateUserID', 'DateUpdated', 'UpdateIPAddress',
        ];
    }

    // definitions
    protected $table = 'GDN_Discussion';
    protected $primaryKey = 'DiscussionID';

    public function getDates()
    {
        return [ 'DateInserted', 'DateUpdated', 'DateLastComment', ];
    }

    // relations
    public function category()
    {
        return $this->hasOne(
            '\BishopB\Vfl\Category', 'CategoryID', 'CategoryID'
        );
    }

    public function comments()
    {
        return $this->hasMany(
            '\BishopB\Vfl\Comment', 'DiscussionID', 'DiscussionID'
        );
    }

    public function first_comment()
    {
        return $this->hasOne(
            '\BishopB\Vfl\Comment', 'CommentID', 'FirstCommentID'
        );
    }

    public function last_comment()
    {
        return $this->hasOne(
            '\BishopB\Vfl\Comment', 'CommentID', 'LastCommentID'
        );
    }

    public function last_commenting_user()
    {
        return $this->hasOne(
            '\BishopB\Vfl\User', 'UserID', 'LastCommentUserID'
        );
    }
}