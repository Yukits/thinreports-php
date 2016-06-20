<?php
/**
 * Created by IntelliJ IDEA.
 * User: yuki
 * Date: 2016/06/17
 * Time: 19:40
 */

namespace Thinreports\Exception;


class ListDisabledException extends StandardException
{
    public function __construct($kind)
    {
        $messages = $kind . ' setting is disabled. could not create ' . $kind;
        parent::__construct($messages);
    }
}
