<?php

declare(strict_types=1);

namespace C14r\Directus;

use C14r\Directus\Request;
use C14r\Directus\API\Helpers;

/**
 * The main class for all Directus API-Requests.
 * 
 * @author Christian Pfeifer <mail@christian-pfeifer.de>
 */
class API extends Request
{
    /**
     * Directus project
     */
    protected ?string $project;

    /**
     *  one-time API token
     */
    protected string $token;

    /**
     * Helper class for query manipulation
     */
    public Helpers $helpers;

    /**
     * Undocumented function
     *
     * @param string $baseUrl       The base URL of yout Directus installation.
     * @param string|null $project  The project you're targetting.
     */
    public function __construct(string $baseUrl, ?string $project = null)
    {
        parent::__construct($baseUrl);

        $this->helpers = new Helpers();
        $this->project = $project;
        $this->parameter('project', $project);
    }

    /**
     * Set's the API token.
     *
     * @param string $token one-time-token
     * @return self
     */
    public function token(string $token): self
    {
        $this->token = $token;

        return $this->header('Authorization', 'Bearer ' . $token);
    }

    /**
     * Check if the giben json object contains an error.
     *
     * @param object $json
     * @return boolean
     */
    public function isError(object $json): bool
    {
        return isset($json->error);
    }

    /**
     * Clears the last request.
     *
     * @return self
     */
    public function clear(): self
    {
        parent::clear();
        $this->parameter('project', $this->project);

        if (isset($this->token)) {
            $this->token($this->token);
        }

        return $this;
    }

    /**
     * Retrieve a Temporary Access Token
     *
     * @param string $email     Email address of the user you're retrieving the access token for.
     * @param string $password  Password of the user.
     * @param string $mode      Choose between retrieving the token as a string, or setting it as a cookie. One of jwt, cookie. Defaults to jwt.
     * @param string $otp       If 2FA is enabled, you need to pass the one time password.
     * @return object           Returns the token (if jwt mode is used) and the user record for the user you just authenticated as.
     */
    public function authenticate(string $email, string $password, string $mode = null, string $otp = null): object
    {
        $response = $this->endpoint(':project/auth/authenticate')->attributes(compact('email', 'password', 'mode', 'otp'))->post();

        if( ! $this->isError($response)) {
            $this->token($response->data->token);
        }

        return $response;
    }

    /**
     * Refresh a Temporary Access Token
     *
     * @return object
     */
    public function tokenRefresh(): object
    {
        $response = $this->endpoint(':project/auth/refresh')->attribute('token', $this->token)->post();

        if( ! $this->isError($response)) {
            $this->token($response->data->token);
        }

        return $response;
    }

    public function custom($endpoint, array $parameters = []): self
    {
        return $this->endpoint('custom/'.ltrim($endpoint, '/'))->parameters($parameters);
    }

    /**
     * Endpoint for all activities
     *
     * @return self
     */
    public function activities(): self
    {
        return $this->endpoint(':project/activity');
    }

    /**
     * Endpoint for one activity
     *
     * @param integer $id   Unique identifier of the item.
     * @return self
     */
    public function activity(int $id): self
    {
        return $this->endpoint(':project/activity/:id')->parameters(compact('id'));
    }

    /**
     * Endpoint for all comments
     *
     * @return self
     */
    public function comments(): self
    {
        return $this->endpoint(':project/activity/comment');
    }

    /**
     * Endpoint for one comment
     *
     * @param integer $id   Unique identifier of the comment (activity).
     * @return self
     */
    public function comment(int $id): self
    {
        return $this->endpoint(':project/activity/comment/:id')->parameters(compact('id'));
    }

    public function asset(string $key): self
    {
        return $this->endpoint(':project/assets/:key')->parameters(compact('key'));
    }

    public function collections(): self
    {
        return $this->endpoint(':project/collections');
    }

    public function collection(string $collection): self
    {
        return $this->endpoint(':project/collections/:collection')->parameters(compact('collection'));
    }

    public function interfaces(): self
    {
        return $this->endpoint('interfaces');
    }

    public function layouts(): self
    {
        return $this->endpoint('layouts');
    }

    public function modules(): self
    {
        return $this->endpoint('modules');
    }

    public function fields(?string $collection = null): self
    {
        if(is_null($collection)) {
            return $this->endpoint(':project/fields');
        }

        return $this->endpoint(':project/fields/:collection')->parameters(compact('collection'));
    }

    public function field(string $collection, string $field): self
    {
        return $this->endpoint(':project/fields/:collection/:field')->parameters(compact('collection', 'field'));
    }

    public function files(): self
    {
        return $this->endpoint(':project/files');
    }

    public function file(int $id): self
    {
        return $this->endpoint(':project/files/:id')->parameters(compact('id'));
    }

    public function fileRevisions(int $id): self
    {
        return $this->endpoint(':project/files/:id/revisions')->parameters(compact('id'));
    }

    public function fileRevision(int $id, int $offset): self
    {
        return $this->endpoint(':project/files/:id/revisions/:offset')->parameters(compact('id', 'offset'));
    }

    public function folders(): self
    {
        return $this->endpoint(':project/folders');
    }

    public function folder(int $id): self
    {
        return $this->endpoint(':project/folders/:id')->parameters(compact('id'));
    }

    public function item(string $collection, $id): self
    {
        return $this->endpoint(':project/items/:collection/:id')->parameters(compact('collection', 'id'));
    }

    public function items(string $collection): self
    {
        return $this->endpoint(':project/items/:collection')->parameters(compact('collection'));
    }

    public function itemRevisions(string $collection, $id): self
    {
        return $this->endpoint(':project/items/:collection/:id/revisions')->parameters(compact('collection', 'id'));
    }

    public function itemRevision(string $collection, $id, int $offset): self
    {
        return $this->endpoint(':project/items/:collection/:id/revisions/:offset')->parameters(compact('collection', 'id', 'offset'));
    }

    public function itemRevert(string $collection, $id, int $revision): self
    {
        return $this->endpoint(':project/items/:collection/:id/revert/:revision')->parameters(compact('collection', 'id', 'revision'));
    }

    public function mail(): self
    {
        return $this->endpoint(':project/mail');
    }

    public function presets(): self
    {
        return $this->endpoint(':project/collection_presets');
    }

    public function preset(int $id): self
    {
        return $this->endpoint(':project/collection_presets/:id')->parameters(compact('id'));
    }

    public function info(string $super_admin_token): self
    {
        return $this->endpoint('server/info')->queries(compact('super_admin_token'));
    }

    public function ping(): self
    {
        return $this->endpoint('server/ping');
    }

    public function hash(string $string): object
    {
        return $this->endpoint(':project/utils/hash')->attributes(compact('string'));
    }

    public function hashMatch(string $string, string $hash): object
    {
        return $this->endpoint(':project/utils/hash/match')->attributes(compact('string', 'hash'));
    }

    public function randomString(int $length = 32): object
    {
        return $this->endpoint(':project/utils/random/string')->attributes(compact('length'));
    }

    public function secret(): object
    {
        return $this->endpoint(':project/utils/2fa_secret');
    }

    public function permissions(): object
    {
        return $this->endpoint(':project/permissions');
    }

    public function permission(int $id): object
    {
        return $this->endpoint(':project/permissions/:id')->parameters(compact('id'));
    }

    public function myPermissions(): object
    {
        return $this->endpoint(':project/permissions/me');
    }

    public function myPermission(string $collection): object
    {
        return $this->endpoint(':project/permissions/me/:collection')->parameters(compact('collection'));
    }

    public function projects(?string $project = null): object
    {
        // This endpoint should use  'project' not 'projects', but unfortunately it has to be here because of the different endpoints :(
        if (!is_null($project)) {
            return $this->endpoint('server/projects/:project')->parameters(compact('project'));
        }
        return $this->endpoint('server/projects');
    }

    public function project(string $project): object
    {
        return $this->endpoint(':project/')->parameters(compact('project')); // should be server/projects/:project :-(
    }

    public function relations(): object
    {
        return $this->endpoint(':project/relations');
    }

    public function relation(int $id): object
    {
        return $this->endpoint(':project/relations/:id')->parameters(compact('id'));
    }

    public function revisions(): object
    {
        return $this->endpoint(':project/revisions');
    }

    public function revision(int $id): object
    {
        return $this->endpoint(':project/revisions/:id')->parameters(compact('id'));
    }

    public function roles(): object
    {
        return $this->endpoint(':project/roles');
    }

    public function role(int $id): object
    {
        return $this->endpoint(':project/roles/:id')->parameters(compact('id'));
    }

    public function scimUsers()
    {
        return $this->endpoint(':project/scim/v2/Users');
    }

    public function scimUser(int $external_id)
    {
        return $this->endpoint(':project/scim/v2/Users/:external_id')->parameters(compact('external_id'));
    }

    public function scimGroups()
    {
        return $this->endpoint(':project/scim/v2/Groups');
    }

    public function scimGroup(int $id)
    {
        return $this->endpoint(':project/scim/v2/Groups/:id')->parameters(compact('id'));
    }
    
    public function settings(): object
    {
        return $this->endpoint(':project/settings');
    }

    public function setting(string $id): object
    {
        return $this->endpoint(':project/settings/:id')->parameters(compact('id'));
    }

    public function users(): object
    {
        return $this->endpoint(':project/users');
    }

    public function user(int $id): object
    {
        return $this->endpoint(':project/users/:id')->parameters(compact('id'));
    }

    public function me(): object
    {
        return $this->endpoint(':project/users/me');
    }

    public function invite(string $email): object
    {
        return $this->endpoint(':project/users/invite')->attributes(compact('email'));
    }

    public function acceptUser(string $token): object
    {
        return $this->endpoint(':project/users/invite/:token')->parameters(compact('token'));
    }

    public function trackingPage(int $id, string $last_page): object
    {
        return $this->endpoint(':project/users/:id/tracking/page')->parameters(compact('id'))->attributes(compact('last_page'));
    }

    public function userRevisions(int $id): object
    {
        return $this->endpoint(':project/users/:id/revisions')->parameters(compact('id'));
    }

    public function userRevision(int $id, int $offset): object
    {
        return $this->endpoint(':project/users/:id/revisions/:offset')->parameters(compact('id', 'offset'));
    }





    public function _single($single = true): self
    {
        return $this->query('single', $this->helpers->single($single));
    }

    public function _limit($limit): self
    {
        return $this->query('limit', $this->helpers->limit($limit));
    }

    public function all(): self
    {
        return $this->_limit(-1);
    }

    public function _offset($offset): self
    {
        return $this->query('offset', $this->helpers->offset($offset));
    }

    public function _page($page): self
    {
        return $this->query('page', $this->helpers->page($page));
    }

    public function _meta($meta = '*'): self
    {
        return $this->query('meta', $this->helpers->meta($meta));
    }
    
    public function _status($status = '*'): self
    {
        return $this->query('status', $this->helpers->status($status));
    }

    public function _sort($sort): self
    {
        return $this->query('sort', $this->helpers->sort($sort));
    }

    public function _q($q): self
    {
        return $this->query('q', $this->helpers->q($q));
    }

    public function _filter($filter): self
    {
        return $this->query('filter', $this->helpers->filter($filter));
    }

    public function _fields($fields): self
    {
        return $this->query('fields', $this->helpers->fields($fields));
    }
}