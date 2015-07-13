<?php

namespace App\Repositories;

use App\Models\CommunityStructure;
use Illuminate\Cache\Repository;

/* Adam Endvy */
class CommunityStructureRepository
{
    public function __construct(CommunityStructure $communityStructure, Repository $cache)
    {
        $this->model = $communityStructure;
        $this->cache = $cache;
    }

    /**
     * Method to add structure
     *
     * @param int $id
     * @param string $title
     * @return boolean
     */
    public function add($id, $title)
    {
        if (!is_numeric($id)) return false;

        if (!$this->exists($id, $title)) {
            $structure = $this->model->newInstance();
            $structure->community_id = $id;
            $structure->title = sanitizeText($title, 100);
            $structure->slug = hash('crc32', $title.time());
            $structure->save();

            $this->cache->forget('community-structure-'.$id);
            return $structure;
        }

        return false;
    }

    public function exists($id, $title)
    {
        return $this->model->where('community_id', '=', $id)->where('title', '=', $title)->first();
    }

    public function get($id, $communityId = null)
    {
        if ($communityId) {
            return $this->model->where('community_id', '=', $communityId)
                ->where(function($query) use($id) {
                   $query->where('id', '=', $id)->orWhere('slug', '=', $id);
                })->first();
        }
        return $this->model->where('id', '=', $id)->orWhere('slug', '=', $id)->first();
    }

    public function delete($id)
    {
        $structure = $this->get($id);

        $this->cache->forget('community-structure-'.$structure->community->id);

        return $structure->delete();
    }

    public function deleteAllByCommunity($id)
    {
        $this->cache->forget('community-structure-'.$id);
        return $this->model->where('community_id', '=', $id)->delete();
    }
}
 