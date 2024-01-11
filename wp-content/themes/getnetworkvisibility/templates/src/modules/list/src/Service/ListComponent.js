import React from 'react';
import axios from "axios";
import {UrlManager} from "./UrlManager";

export default class ListComponent extends React.Component {
    constructor(props) {
        super(props);

        this.state = {
            params: new Map,
            totalPages: 0,
            totalPosts: 0,
            loadMore: false,
            loaded: false,
            list: new Map,
        };

        this.config = (this.props && this.props.config) ? this.props.config : false;
        this.searchKey = false;
        this.objPublishEvents = null;
        this.page = null;
        this.source = this.config ? this.config.source : false;
        this.isLoadMore = (this.config.loadMore === undefined || this.config.loadMore === 'loadMore');
        this.isPagination = (this.config.loadMore !== undefined && this.config.loadMore === 'pagination');

        this.querySearchBy = false;
        this.searchRef = false;
        this.refPrincipalContainer = React.createRef();

        this.UrlManager = UrlManager.getInstance();

        this.startScroll = false;
        this.domLoadedAutoScroll = (this.config && this.config.hasOwnProperty('domLoadedAutoScroll')) ? this.config.domLoadedAutoScroll : false;
        this.isScrolled = false;
        this.debugService = false;

        this.sleep = this.sleep.bind(this);
        this.addPublishEvents = this.addPublishEvents.bind(this);
        this.publishEvents = this.publishEvents.bind(this);
        this.resetPublishEvents = this.resetPublishEvents.bind(this);
        this.setParams = this.setParams.bind(this);
        this.incrementPage = this.incrementPage.bind(this);
        this.changePage = this.changePage.bind(this);
        this.resetPage = this.resetPage.bind(this);
        this.loaded = this.loaded.bind(this);
        this.getList = this.getList.bind(this);
        this.requestList = this.requestList.bind(this);
        this.getResponseTotalPages = this.getResponseTotalPages.bind(this);
        this.getResponseTotalPosts = this.getResponseTotalPosts.bind(this);
        this.clearAllFilter = this.clearAllFilter.bind(this);
        this.searchBy = this.searchBy.bind(this);
        this.rewriteUrl = this.rewriteUrl.bind(this);
        this.removePage = this.removePage.bind(this);
        this.hasParams = this.hasParams.bind(this);
        this.renderParams = this.renderParams.bind(this);
        this.eventScrollElement = this.eventScrollElement.bind(this);
        this.scrollChangePage = this.scrollChangePage.bind(this);
    }

    componentDidMount() {
        const $this = this;
        let $hasSearchFilter = false;

        if($this.domLoadedAutoScroll) {
            $this.eventScrollElement();
        }

        if ($this.config && $this.config.filters && $this.config.filters.hasOwnProperty('search')) {
            this.searchKey = $this.config.filters.search.key;
            $hasSearchFilter = true;
        }

        if ($this.config && $this.config.filters) {
            let $params = $this.state.params;

            if ($this.config.filters.hasOwnProperty('search') && $this.config.filters.search.default) {
                $params.set('search', $this.config.filters.search.default);
            }

            if ($this.config.filters.hasOwnProperty('page') && $this.config.filters.page.default) {
                $params.set('page', $this.config.filters.page.default);
            }

            for (let $filter of Object.values($this.config.filters)) {
                if ($filter.key === 'search' || $filter.key === 'page' || !$filter.default) {
                    continue;
                }

                if (($filter.default instanceof Array) || ($filter.default instanceof Object)) {
                    Object.values($filter.default).map(($default) => {
                        $params = $this.setParamsValue($params, $filter.key, $default);
                    });
                } else {
                    $params = $this.setParamsValue($params, $filter.key, $filter.default);
                }
            }

            $this.setState({params: $params}, () => $this.getList());
        }

        if ($hasSearchFilter) {
            delete $this.config.filters.search;
        }
    }

    /**
     *
     * @param {number} $timeout
     */
    eventScrollElement($timeout = 500) {
        if (this.refPrincipalContainer && this.refPrincipalContainer.current) {
            setTimeout(() => {
                let evt = new CustomEvent('scrollToDOMElement', {
                    "detail": this.refPrincipalContainer.current
                });
                document.dispatchEvent(evt);
            }, $timeout);
        }
    }

    /**
     *
     * @param {number} $millisecond
     * @returns {Promise<unknown>}
     */
    sleep = ($millisecond = 500) => {
        return new Promise(resolve => setTimeout(resolve, $millisecond));
    }

    /**
     *
     * @param {true|false} $loaded
     * @param {function} $callback
     */
    loaded($loaded = false, $callback = () => {
    }) {
        const $this = this;

        $this.setState({loaded: $loaded}, () => {
            if (!$loaded) {
                $callback();
            }
        })
    }

    /**
     *
     * @param {function} $callback
     */
    clearAllFilter($callback = () => {
    }) {
        const $this = this;
        const {state: {params: $params}} = $this;

        $params.clear();

        if ($this.searchRef) {
            $this.searchRef.value = '';
        }

        $this.setState({params: $params}, () => {
            $this.loaded(false, () => {
                $callback();
                $this.getList();
            });
        });
    }

    getList() {
        const $this = this;

        setTimeout(async () => {
            if (!$this.source) {
                return false;
            }

            await $this.sleep(500);

            let $params = {};
            if ($this.state.params.size) {
                if ($this.state.params.has('page')) {
                    $params.page = $this.state.params.get('page');
                }
                if ($this.state.params.has($this.searchKey)) {
                    $params[$this.searchKey] = $this.state.params.get($this.searchKey);
                }

                $this.state.params.forEach(($param, $key) => {
                    if (['page', $this.searchKey].indexOf($key) > -1) {
                        return false;
                    }

                    if(($param instanceof Map)) {
                        $params[$key] = [];
                        $param.forEach(($value) => $params[$key].push($value));
                    }else{
                        $params[$key] = $param;
                    }
                });
            }

            $this.requestList(axios.get($this.source, {
                params: $params,
            }));
        }, 0);
    }

    requestList($request) {
        const $this = this;
        $request.then(({data: $articles, request: $request}) => {
            $this.getResponseTotalPages($request);
            $this.getResponseTotalPosts($request);
            const $list = $this.state.list;

            if ($list.size && $this.isPagination) {
                $list.clear();
            }

            $articles.map($article => $list.set($list.size, $article));

            $this.setState({
                list: $list,
                loaded: true,
                loadMore: false,
            }, () => {
                if($this.config.disabledAutoScroll !== true) {

                    if(!$this.isScrolled) {
                        if ($this.startScroll) {
                            $this.eventScrollElement();
                        }
                        $this.startScroll = true;
                    }
                }

                $this.rewriteUrl();
                $this.publishEvents();
            });
        });
    }

    rewriteUrl() {
        const $this = this;
        $this.UrlManager.$params = $this.state.params;
        $this.UrlManager.pushState();
    }

    addPublishEvents(event) {
        if (!event) {
            return false;
        }

        this.objPublishEvents = !this.objPublishEvents ? [] : this.objPublishEvents;
        this.objPublishEvents.push(event);
    }

    publishEvents() {
        let self = this;
        if (self.objPublishEvents) {
            self.objPublishEvents.map(event => document.dispatchEvent(new Event(event)));

            self.resetPublishEvents();
        }
    }

    resetPublishEvents() {
        this.objPublishEvents = null;
    }

    /**
     *
     * @param $key
     * @param $value
     * @param {boolean} $callGetList
     */
    setParams($key, $value, $callGetList = true) {
        const $this = this;
        const {state: {params: $params}} = $this;

        $this.setParamsValue($params, $key, $value);

        $this.setState({params: $params}, () => {
            if ($callGetList) {
                $this.loaded(false, $this.getList)
            }
        });
    }

    /**
     *
     * @param {Map} $params
     * @param {string} $key
     * @param {mixed} $value
     * @returns {*}
     */
    setParamsValue($params, $key, $value) {
        const $this = this;

        switch ($key) {
            case $this.searchKey:
                $params.clear();

                if ($value) {
                    $params.set($key, $value);
                }

                $this.rewriteUrl();
                break;
            case 'page':
                $this.changePage($value);
                break;
            default:
                $params = $this.removePage($params);

                if (!$params.has($key)) {
                    $params.set($key, new Map);
                }

                if (!$params.get($key).has($value)) {
                    $params.get($key).set($value, $value);
                } else {
                    $params.get($key).delete($value);
                }

                if ($params.get($key).size === 0) {
                    $params.delete($key);
                }
                break;
        }

        return $params;
    }

    scrollChangePage() {
        const $this = this;

        $this.isScrolled = true;
        $this.eventScrollElement(1);
    }

    incrementPage() {
        const $this = this;
        const {state: {params: $params}} = $this;

        $this.scrollChangePage();

        $params.set('page', parseInt($params.get('page')) + 1);

        $this.setState({params: $params}, () => {
            $this.loaded(false, $this.getList)
        });
    }

    changePage($page = 1) {
        const $this = this;
        const {state: {params: $params}} = $this;

        $this.scrollChangePage();

        $params.set('page', $page);

        $this.setState({params: $params}, () => {
            $this.loaded(false, $this.getList);
        });
    }

    /**
     *
     * @param {boolean} $callSetState
     */
    resetPage($callSetState = true) {
        const $this = this;
        const {state: {params: $params}} = $this;
        
        $this.scrollChangePage();

        $this.setState({params: $this.removePage($params)}, () => {
            $this.loaded(false, $this.getList)
        });
    }

    /**
     *
     * @param {Map} $params
     * @returns {Map}
     */
    removePage($params) {
        if ($params.has('page')) {
            const $this = this;
            $this.scrollChangePage();
            
            $params.delete('page');
        }

        return $params;
    }

    getResponseTotalPages(request) {
        if (request && request.getResponseHeader) {
            let pages = request.getResponseHeader('x-wp-totalpages');

            this.setState({
                totalPages: pages ? parseInt(pages) : 0
            })
        }
    }

    getResponseTotalPosts(request) {
        if (request && request.getResponseHeader) {
            let posts = request.getResponseHeader('x-wp-total');

            this.setState({
                totalPosts: posts ? parseInt(posts) : 0
            })
        }
    }

    searchBy($event) {
        $event.preventDefault();

        const $this = this;
        const $value = $event.target.value;

        if ($this.querySearchBy) {
            clearTimeout($this.querySearchBy);
        }

        $this.querySearchBy = setTimeout(() => {
            $this.setParams($this.searchKey, $value);
        }, 1000);
    }

    hasParams() {
        const $this = this;

        return (($this.state.params.size > 1) || ($this.state.params.size === 1 && !$this.state.params.has('page')));
    }

    renderParams() {
        const $this = this;
        const {state: {params: $params}} = $this;
        const $htmlParams = [];

        if ($params.size) {
            $params.forEach(($value, $param) => {

                switch ($param) {
                    case $this.searchKey:
                        $htmlParams.push(<a href={`#`} onClick={($event) => {
                            $event.preventDefault();
                            if ($this.searchRef) {
                                $this.searchRef.value = '';
                            }
                            $this.setParams($this.searchKey, '');
                        }}>{$value}</a>);
                        break;
                    case 'page':
                        break;
                    default:
                        if ($value.size) {
                            $value.forEach(($v) => {
                                const $filter = $this.config.filters[$param];
                                let $choice = $filter.choices ? $filter.choices.filter($c => $c.value === $v) : false;

                                if ($choice.length) {
                                    $choice = Object.values($choice)[0];
                                }

                                $htmlParams.push(<a href={`#${$v}`} onClick={($event) => {
                                    $event.preventDefault();
                                    $this.onClick($param, $v);
                                }}>{$choice.label ?? ''}</a>);
                            });
                        }
                        break;
                }

            });
        }

        return $htmlParams;
    }
}