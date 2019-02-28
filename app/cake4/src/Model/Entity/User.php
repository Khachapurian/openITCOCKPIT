<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * User Entity
 *
 * @property int $id
 * @property int $usergroup_id
 * @property int $status
 * @property string $email
 * @property string $password
 * @property string $firstname
 * @property string $lastname
 * @property string|null $position
 * @property string|null $company
 * @property string|null $phone
 * @property string|null $timezone
 * @property string|null $dateformat
 * @property string|null $image
 * @property string|null $onetimetoken
 * @property string|null $samaccountname
 * @property string|null $ldap_dn
 * @property bool $showstatsinmenu
 * @property int $dashboard_tab_rotation
 * @property int $paginatorlength
 * @property int $recursive_browser
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\Usergroup $usergroup
 * @property \App\Model\Entity\Apikey[] $apikeys
 * @property \App\Model\Entity\Changelog[] $changelogs
 * @property \App\Model\Entity\Contact[] $contacts
 * @property \App\Model\Entity\DashboardTab[] $dashboard_tabs
 * @property \App\Model\Entity\InstantreportsToUser[] $instantreports_to_users
 * @property \App\Model\Entity\MapUpload[] $map_uploads
 * @property \App\Model\Entity\Systemfailure[] $systemfailures
 * @property \App\Model\Entity\UsersToAutoreport[] $users_to_autoreports
 * @property \App\Model\Entity\UsersToContainer[] $users_to_containers
 */
class User extends Entity {

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'usergroup_id'            => true,
        'status'                  => true,
        'email'                   => true,
        'password'                => true,
        'firstname'               => true,
        'lastname'                => true,
        'position'                => true,
        'company'                 => true,
        'phone'                   => true,
        'timezone'                => true,
        'dateformat'              => true,
        'image'                   => true,
        'onetimetoken'            => true,
        'samaccountname'          => true,
        'ldap_dn'                 => true,
        'showstatsinmenu'         => true,
        'dashboard_tab_rotation'  => true,
        'paginatorlength'         => true,
        'recursive_browser'       => true,
        'created'                 => true,
        'modified'                => true,
        'usergroup'               => true,
        'apikeys'                 => true,
        'changelogs'              => true,
        'contacts'                => true,
        'dashboard_tabs'          => true,
        'instantreports_to_users' => true,
        'map_uploads'             => true,
        'systemfailures'          => true,
        'users_to_autoreports'    => true,
        'users_to_containers'     => true
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password'
    ];

    /**
     * @var array
     */
    protected $_virtual = ['full_name'];

    /**
     * @return string
     */
    protected function _getFullName() {
        return $this->firstname . ' ' . $this->lastname;
    }
}
