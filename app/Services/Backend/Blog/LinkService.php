<?php

// app/Services/Backend/Link/LinkService.php
namespace App\Services\Backend\Blog;

use App\Models\Link;

class LinkService
{
    public function getAllLinks()
    {
        return Link::all();
    }

    public function getLinksForDatatables()
    {
        return Link::select([
            'id',
            'link_title',
            'link_url',
            'link_target',
            'link_image',
            'link_type',
            'created_at',
            'updated_at'
        ]);
    }

    public function storeLink(array $data)
    {
        return Link::create([
            'link_title' => $data['tautan_name'],
            'link_url' => $data['tautan_url'],
            'link_target' => $data['tautan_target'],
            'link_type' => 'link',
        ]);
    }

    public function updateLink(Link $link, array $data)
    {
        $link->link_title = $data['link_title'];
        $link->link_url = $data['link_url'];
        $link->link_target = $data['link_target'];
        $link->link_type = 'link';
        $link->save();

        return $link;
    }

    public function deleteLink(Link $link)
    {
        $link->delete();
    }
}
