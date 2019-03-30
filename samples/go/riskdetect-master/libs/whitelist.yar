include "whitelists/phpmyadmin.yar"

private rule IsWhitelisted
{
    condition:
        safe_Phpmyadmin
}
