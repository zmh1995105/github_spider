<?php
namespace App;

use Lavender\Support\SharedEntity;

class Theme extends SharedEntity
{

    public function getTheme()
    {
        return entity('theme')->find($this->id);
    }


    public function bootTheme($store)
    {
        // Load the theme assigned to the current store
        if($store->exists && $theme = $store->getTheme()){

            // Now that we have our theme loaded, lets collect the fallbacks
            $theme->fallbacks = $this->themes($theme);

            $this->setEntity($theme);

            return $theme->exists;
        }
        return false;
    }

    /**
     * Merge inherited theme routes
     * @param Theme $theme
     * @internal param int $theme_id
     * @return array
     */
    protected function themes($theme)
    {
        $themes[] = $theme->code;

        $parent = $theme->parent;

        if($parent->id != $theme->id){

            $themes = array_merge(
                $themes,
                $this->themes($parent)
            );
        }

        return $themes;
    }

}