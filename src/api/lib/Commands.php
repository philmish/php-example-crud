<?php declare(strict_types=1);

namespace mvcex\api\lib;

enum Command {
    case LOGIN;
    case LOGOUT;
    case FETCH_NOTE;
    case FETCH_NOTES;
}
