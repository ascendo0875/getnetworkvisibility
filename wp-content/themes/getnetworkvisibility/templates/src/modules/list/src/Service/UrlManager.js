class UrlManagerService {
    /**
     *
     * @type {UrlManagerService}
     */
    static #$instance;

    /**
     *
     * @returns {UrlManagerService}
     */
    static getInstance() {
        if (!this.#$instance) {
            this.#$instance = new UrlManagerService();
        }

        return this.#$instance;
    }

    /**
     *
     * @type {string|false}
     */
    #$locationHref = false;

    /**
     *
     * @type {Map}
     */
    #$params = new Map;

    constructor() {
        this.#$locationHref = window.location.origin + window.location.pathname ?? false;
    }

    /**
     *
     * @returns {string|false}
     */
    get $locationHref() {
        return this.#$locationHref;
    }

    /**
     *
     * @param {string|false} value
     */
    set $locationHref(value) {
        this.#$locationHref = value;
    }

    /**
     *
     * @returns {Map}
     */
    get $params() {
        return this.#$params;
    }

    /**
     *
     * @param {Map} value
     */
    set $params(value) {
        this.#$params = value;
    }

    /**
     *
     * @param {string} $url
     */
    pushState($url = false) {
        const $redirect = ($url !== false);

        if (!$url) {
            $url = this.#$locationHref;
        }

        if ($url) {
            if ($url.indexOf(`${window.location.protocol}//`) === -1) {
                $url = `${window.location.origin}${$url}`;
            }
            
            const $this = this;
            const $Url = new URL('', $url);

            if ($this.#$params.size) {
                const $searchParams = $Url.searchParams;

                $this.#$params.forEach(($param, $key) => {
                    if (($param instanceof Map)) {
                        $param.forEach(($p) => {
                            $searchParams.append(`${$key}[]`, $p);
                        });
                    } else {
                        $searchParams.set($key, $param);
                    }
                });
            }

            if (window.location.href !== $Url.toString()) {
                if(!$redirect) {
                    window.history.pushState({}, '', $Url);
                }if($redirect) {
                    window.location = $Url;
                }
            }
        }
    }
}

export const UrlManager = UrlManagerService;