<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\Response;
use App\Models\ShortLinks as ShortLinksModel;
use Illuminate\Http\Request;

class ShortLinks extends Controller
{
    /**
     * JSON API handle for generating Short Link.
     */
    public function generate(Request $request): Response
    {
        $json = $request->json()->all();
        if (array_key_exists('link', $json)) {
            if (strlen($json['link']) > 1) {
                if (strlen($json['link']) <= ShortLinksModel::LINK_MAX_LENGTH) {
                    if (filter_var($json['link'], FILTER_VALIDATE_URL)) {
                        $result = ShortLinksModel::generateAndAdd($json['link']);
                        return response()->json([
                            'status'           => 'ok',
                            'data'             => $result['id'], // hash
                            'safe_status_bool' => $result['safe_status_bool'],
                            'safe_status_text' => $result['safe_status_text'],
                        ]);
                    } else return response()->json(['status' => 'error', 'data' => 'Link is incorrect!']);
                }     else return response()->json(['status' => 'error', 'data' => 'Link is too long!']);
            }         else return response()->json(['status' => 'error', 'data' => 'Link is empty!']);
        }             else return response()->json(['status' => 'error', 'data' => 'Link is not presenter in JSON!']);
    }

    /**
     * Short Link Redirector from "/short_links/go/{hash}".
     */
    public function go(Request $request, string $hash): mixed
    {
        $data = ShortLinksModel::find($hash);
        if (isset($data->link)) {
            return redirect()->to($data->link);
        } else abort(404);
    }

    /**
     * Short Link Redirector from "{any_path}/{hash}".
     */
    public function goAny(Request $request, string $path, string $hash): mixed
    {
        $data = ShortLinksModel::find($hash);
        if (isset($data->link)) {
            return redirect()->to($data->link);
        } else abort(404);
    }
}
