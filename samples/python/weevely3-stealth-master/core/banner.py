import sys
import random

from core.colors import color, yellow, green, bold


def logo(version):
    """weevely asciiarts.
    :param version: version string
    @return: asciiarts array.
    """
    logos = []
    logos.append("""
                                  .__
__  _  __ ____   _______  __ ____ |  | ___.__.
\ \/ \/ // __ \_/ __ \  \/ // __ \|  |<   |  |
 \     /\  ___/\  ___/\   /\  ___/|  |_\___  |
  \/\_/  \___  >\___  >\_/  \___  >____/ ____|
             \/     \/          \/     \/
  %s-enhanced""" % version)
    #return color(random.choice(logos), random.randrange(31, 37))
    return bold(green(random.choice(logos)))

