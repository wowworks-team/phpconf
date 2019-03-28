<?php

namespace common\services\Jira;

class JiraService
{
    const TYPE_USER = 'user';
    const TYPE_PROJECT = 'project';

    /** @var string */
    private $jiraHost;

    /** @var string */
    private $jiraUsername;

    /** @var string */
    private $jiraToken;

    public function __construct(string $jiraHost, string $jiraUserName, string $jiraToken)
    {
        $this->jiraHost = $jiraHost;
        $this->jiraUsername = $jiraUserName;
        $this->jiraToken = $jiraToken;
    }

    // ...
}
