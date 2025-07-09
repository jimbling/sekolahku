<?php



if (!function_exists('is_menu_active')) {
    /**
     * Checks if a menu item or any of its children is active.
     *
     * @param array $menuItem The menu item array.
     * @return bool
     */
    function is_menu_active(array $menuItem): bool
    {
        // Add 'admin/*' prefix to the pattern for matching with Request::is()
        $pattern = 'admin/' . ltrim($menuItem['pattern'] ?? '', '/');

        // 1. Check if the menu item's own pattern matches the current URL
        if (isset($menuItem['pattern']) && Request::is($pattern)) {
            return true;
        }

        // 2. If it has children, recursively check each child
        if (isset($menuItem['children'])) {
            foreach ($menuItem['children'] as $child) {
                // If any child is active, then the parent is also active
                if (is_menu_active($child)) {
                    return true;
                }
            }
        }

        // 3. If no match is found, return false
        return false;
    }
}
