<?php

namespace DieSchittigs\ContaoFlashBundle\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Contao\Flash;
/**
 * @Route("/flash", defaults={"_scope" = "frontend", "_token_check" = false})
 */
class FlashController extends Controller {
    
    /**
     * Base 64 encoded contents for 1px transparent gif and png
     * @var string
     */
    const IMAGE_CONTENT = 'R0lGODlhAQABAJAAAP8AAAAAACH5BAUQAAAALAAAAAABAAEAAAICBAEAOw==';

    /**
     * @return Response
     *
     * @Route("/get", name="flash_get", methods={"GET"})
     */
    public function getMessages(Request $request) {
        return $this->json(Flash::load());
    }

    /**
     * @return Response
     *
     * @Route("/clear", name="flash_clear", methods={"GET"})
     */
    public function clear(Request $request) {
        $ids = explode(',', $request->get('ids', ''));
        $ids[] = $request->get('id', null);
        foreach($ids as $id){
            if(!$id) continue;
            Flash::purge($id);
        }
        if($request->get('img')) {
            $response = new Response(base64_decode(self::IMAGE_CONTENT), 200, ['Content-Type' => 'image/gif']);
            return $response;
        }
        $referer = $request->headers->get('referer');
        if($referer && !$request->isXmlHttpRequest()) return new RedirectResponse($referer);
        return $this->json([]);
    }

    
}