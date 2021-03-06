<?php
declare(strict_types=1);

namespace Infrastructure;

use Application\Exception\NotFound\RequestHeaderNotFoundException;
use Domain\Host;
use Symfony\Component\HttpFoundation\Request;

final class HostFactory
{
    /**
     * @param Request $request
     *
     * @throws RequestHeaderNotFoundException
     *
     * @return Host
     */
    public static function fromRequest(Request $request) : Host
    {
        $domain = $request->headers->get('referer');

        if ($domain === null) {
            $domain = $request->headers->get('origin');
        }

        if ($domain === null) {
            throw new RequestHeaderNotFoundException('Origin nor Referer');
        }

        $schema = parse_url($domain, PHP_URL_SCHEME);
        $host = parse_url($domain, PHP_URL_HOST);

        return new Host($schema, $host);
    }
}
