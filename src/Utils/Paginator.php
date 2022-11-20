<?php

namespace Theme2022\Utils;

class Paginator {
    private $maxPages;

    public function __construct($maxPages = '') {
        if (!empty($maxPages)) {
            $this->maxPages = $maxPages;
        }
    }

    public function generateOptimizedPagination() {
        global $paged;
        global $wp_query;

        $out = '';
        $paged = !empty($paged) ? $paged : 1;
        $slug = "/blog";

        if (is_tag()) {
            $slug = get_tag_link(get_queried_object()->term_id);
        } else if (is_category()) {
            $slug = get_category_link(get_queried_object()->term_id);
        }

        if ($this->maxPages == '') {
            $this->maxPages = $wp_query->max_num_pages;
            if (!$this->maxPages) {
                $this->maxPages = 1;
            }
        }

        $range = 10;
        $visible_range = floor($paged / 10) * 10;

        $leftarrow = $visible_range - 1;
        $rightarrow = $visible_range + $range;

        // == DEBUT RENDU HTML ==
        $out .= '<div class="pagination clearfix">';

        if (1 != $this->maxPages) {
            if ($this->maxPages <= 10) {
                $out .= '<div class="pagination__simple">';

                for ($i = 1; $i <= $this->maxPages; $i++) {
                    $class = $i == $paged ? "active" : "inactive";
                    if ($i == 1) {
                        $out .= '<a class="' . $class . '" href="' . $slug . '">' . $i . '</a>';
                    } else {
                        $out .= '<a class="' . $class . '" href="' . $slug . '/page/' . $i . '">' . $i . '</a>';
                    }
                }

                $out .= '</div>';
            } else {
                /* PAGES DANS LA DIZAINE */

                $out .= '<div class="pagination__simple">';
                // fleches de gauche
                if ($visible_range != 0) {
                    $out .= '<a class="inactive arrow first" href="' . $slug . '"><span class="icon-first"></span></a>';
                    $out .= '<a class="inactive arrow previous" href="' . $slug . '/page/' . $leftarrow . '"><span class="icon-prev"></span></a>';
                }

                //pages
                for ($i = $visible_range; $i < $visible_range + $range; $i++) {
                    // marquer la page active
                    $class = $i == $paged ? "active" : "inactive";

                    if ($i != 0) {
                        if ($i == 1) {
                            $out .= '<a class="' . $class . '" href="' . $slug . '">' . $i . '</a>';
                        } else {
                            $out .= '<a class="' . $class . '" href="' . $slug . '/page/' . $i . '">' . $i . '</a>';
                        }
                    }

                    if ($i == $this->maxPages) {
                        break;
                    }
                }

                // fleches de droite
                if ($paged < $this->maxPages - $range) {
                    $out .= '<a class="inactive arrow next" href="' . $slug . '/page/' . $rightarrow . '"><span class="icon-next"></span></a>';
                    $out .= '<a class="inactive arrow last" href="' . $slug . '/page/' . $this->maxPages . '"><span class="icon-end"></span></a>';
                }

                $out .= '</div>';

                $out .= '<div class="pagination__jumps">';

                /* dizaines */
                $out .= '<div>';
                $visible_range = floor($paged / 100) * 100;

                // écriture des pages
                for ($i = $visible_range + 10; $i < $visible_range + $range * 10; $i += 10) {
                    if ($i > $this->maxPages)
                        break;

                    if ($i != 0 && $i > $paged)
                        $out .= '<a class="inactive" href="' . $slug . '/page/' . $i . '">' . $i . '</a>';
                }

                // Si dernière page de la dizaine, affiche dizaine supérieur
                if ($paged >= $i - 10) {
                    for ($i = $visible_range + 100; $i < $visible_range + $range * 10 + 100; $i += 10) {
                        if ($i < $this->maxPages)
                            $out .= '<a class="inactive" href="' . $slug . '/page/' . $i . '">' . $i . '</a>';
                    }
                }

                $out .= "</div>";
                $out .= '<div>';

                /* centaine */
                $visible_range = floor($paged / 1000) * 1000;
                for ($i = $visible_range + 100; $i < $visible_range + $range * 100; $i += 100) {
                    if ($i > $this->maxPages)
                        break;

                    if ($i > $paged + 10)
                        $out .= '<a class="inactive" href="' . $slug . '/page/' . $i . '">' . $i . '</a>';
                }

                // Si dernière page de la centaine, affiche centaine supérieur
                if ($paged >= $i - 100) {
                    for ($i = $visible_range + 1000 + 100; $i < $visible_range + $range * 100 + 1000; $i += 100) {
                        if ($i < $this->maxPages)
                            $out .= '<a class="inactive" href="' . $slug . '/page/' . $i . '">' . $i . '</a>';
                    }
                }

                $out .= "</div>";
                $out .= '<div>';

                /* PAGES DANS LE MILLIEME */
                $visible_range = floor($paged / 10000) * 10000;
                for ($i = $visible_range + 1000; $i < $visible_range + $range * 1000; $i += 1000) {
                    if ($i > $this->maxPages)
                        break;

                    if ($i > $paged + 100)
                        $out .= '<a class="inactive" href="' . $slug . '/page/' . $i . '">' . $i . '</a>';
                }

                // END
                $out .= "</div>";
                $out .= "</div>";
            }
        }

        return $out . '</div>';
    }
}
