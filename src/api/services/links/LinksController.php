<?php declare(strict_types=1);

namespace mvcex\api\services\links;

use mvcex\api\lib\APIController;
use mvcex\api\lib\APIResponse;
use mvcex\api\lib\Command;
use mvcex\api\lib\DBConnector;
use mvcex\api\lib\handlers\GetHandler;
use mvcex\api\lib\handlers\PostHandler;
use mvcex\api\lib\middleware\WaresChain;
use mvcex\api\services\links\handlers\FetchLink;
use mvcex\api\services\links\handlers\FetchTopicLinks;

final class LinksController extends  APIController {
    
    static public function fromEnv(): APIController {
        return new self(DBConnector::fromEnv());
    }

    private function fetchLink(): APIResponse {
        $handlers = [new GetHandler, new FetchLink()];
        $chain = new WaresChain(null, $handlers, $this->db);
        $result = $chain->runChain();
        return $result;
    }

    private function saveLink(): APIResponse {
        $handlers = [new PostHandler, new SaveLink()];
        $chain = new WaresChain(null, $handlers, $this->db);
        $result = $chain->runChain();
        return $result;
    }

    private function fetchTopicLinks(): APIResponse {
        $handlers = [new GetHandler, new FetchTopicLinks()];
        $chain = new WaresChain(null, $handlers, $this->db);
        $result = $chain->runChain();
        return $result;
    }

    public function execute(?Command $cmd): APIResponse {
        $result = match ($cmd) {
            Command::FETCH_LINK => $this->fetchLink(),
            Command::SAVE_LINK => $this->saveLink(),
            Command::FETCH_TOPIC_LINKS => $this->fetchTopicLinks(),
            default => new APIResponse(400, ["Unknown command"]),
        };
        return $result;
    }
}


