<?php declare(strict_types=1);

namespace mvcex\api\lib;

enum Command {
    case LOGIN;
    case LOGOUT;
    case FETCH_NOTE;
    case FETCH_NOTES;
    case CREATE_NOTE;
    case FETCH_LINK;
    case SAVE_LINK;
    case FETCH_TOPIC_LINKS;
}
