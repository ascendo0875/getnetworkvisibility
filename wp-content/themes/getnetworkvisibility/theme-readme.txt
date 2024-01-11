1. Register Post Types
    - wp-content/themes/mimedx/src/PostType/Register/Bio.php
    - wp-content/themes/mimedx/config.php

2. Rename Default Post Type (e.g.: Insights)
    - add new action in wp-content/themes/mimedx/src/Theme.php

4. Register Taxonomy
    - wp-content/themes/mimedx/src/Taxonomy/Position.php
    - wp-content/themes/mimedx/config.php

    Optional: - wp-content/themes/mimedx/src/PostType/Register/Bio.php

5. P2P Register Connection Types
    - wp-content/themes/mimedx/src/PostType/Register/Bio.php
    - Bio::p2pInit

7. Register Sidebar
    - wp-content/themes/ud/src/Theme.php
    - Theme::WIDGETS

8. Register Nav Menus
    - wp-content/themes/ud/src/Theme.php
    - Theme::NAV_MENUS

9. Register Style & Script
    - wp-content/themes/ud/src/Theme.php

10. Add Image Size (crops)
    - wp-content/themes/ud/src/Theme.php
    - Theme::IMAGE_SIZES

12. Register Block Style (core/paragraph, etc.)
    - wp-content/themes/mimedx/src/Block/Register/Heading.php

13. Block Editor Assets (gutenberg.js)
    - wp-content/themes/mimedx/src/Theme.php

14. ACF Blocks (definitions)
    - wp-content/themes/mimedx/src/Block/Register/Tabs.php
    - wp-content/themes/mimedx/template-parts/blocks/tabs.php
    - wp-content/themes/mimedx/config.php

15. Patterns
    - wp-content/themes/mimedx/src/Patterns.php

------------------
ACF - /wp-admin/edit.php?post_type=acf-field-group

------------------
Generate - /wp-admin/admin.php?page=wp_advance_custom_fields_extend
