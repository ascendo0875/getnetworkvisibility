import ListComponent from "../Service/ListComponent";
import Popup from "../Design/Popup";
import EventList from "../Design/EventList";
import Pagination from "../Design/Pagination";
import React from "react";
import ContentNone from "../Design/ContentNone";

export default class Events extends ListComponent {
    constructor(props) {
        super(props);

        this.state = {
            ...this.state,
            isOpenPopup: false,
            filterShowMore: new Map,
        };

        this.popup = this.popup.bind(this);
        this.onClick = this.onClick.bind(this);
        this.filterShowMore = this.filterShowMore.bind(this);
        this.renderParams = this.renderParams.bind(this);
        this.handleTypeEvent = this.handleTypeEvent.bind(this);

        this.loadedComponentDidMount = false;
    }

    requestList($request) {
        const $this = this;

        if(!$this.loadedComponentDidMount) {
            $this.loadedComponentDidMount = true;
        }
        super.requestList($request);
    }
    
    /**
     *
     * @param {MouseEvent} $event
     * @param {boolean} $stopRedirect
     */
    popup($event, $stopRedirect = false) {
        $event.stopPropagation();
        if ($event && $event.preventDefault) {
            $event.preventDefault();
        }

        const $this = this;
        const {state: {isOpenPopup: $isOpenPopup}, config: {redirectToSearch: $redirectToSearch}} = $this;

        if ($isOpenPopup) {
            this.addPublishEvents('fp.closePopup');
        } else {
            this.addPublishEvents('fp.openPopup');
        }

        $this.isSubmitForm = ($redirectToSearch && $isOpenPopup);

        $this.setState({isOpenPopup: !$isOpenPopup}, () => {
            if ($this.isSubmitForm && $stopRedirect === false) {
                $this.forceRedirect();
                return;
            }

            $this.publishEvents();
        });
    }

    /**
     *
     * @param {string} $param
     * @param {string} $value
     */
    onClick($param, $value) {
        super.setParams($param, $value);
    }

    /**
     *
     * @param {string} $filterKey
     */
    filterShowMore($filterKey) {
        const $this = this;
        const {state: {filterShowMore: $filterShowMore}} = $this;

        $filterShowMore.set($filterKey, $filterShowMore.has($filterKey) ? !$filterShowMore.get($filterKey) : true);

        $this.setState({filterShowMore: $filterShowMore})
    }

    handleTypeEvent($event) {
        $event.preventDefault();
        const $this = this;

        if($this.loadedComponentDidMount) {
            $this.loadedComponentDidMount = false;
        }

        $this.loaded(false);
        $this.setParams('ftype', ($this.state.params.has('ftype') && $this.state.params.get('ftype') === 'past') ? 'upcoming' : 'past', false);
        $this.resetPage();
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
                    case 'ftype':
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
            case 'ftype':
                $params.set($key, $value);
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

    hasParams() {
        const {state: {params: $params}} = this;
        const $hasParams = super.hasParams();

        return (($hasParams && !$params.has('ftype')) || ($hasParams && $params.has('ftype') && $params.size > 1));
    }

    clearAllFilter($callback = () => {
    }) {
        const $this = this;
        const {state: {params: $params}} = $this;
        const $cloneParams = new Map($params);

        $params.clear();

        if ($cloneParams.has('ftype')) {
            $params.set('ftype', $cloneParams.get('ftype'));
        }

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

    render() {
        const $this = this;
        const {
            popup: $popup,
            onClick: $onClick,
            clearAllFilter: $clearAllFilter,
            filterShowMore: $filterShowMore,
            renderParams: $RenderParams,
            hasParams: $hasParams,
            handleTypeEvent: $handleTypeEvent,
            isPagination: $isPagination,
            config: {
                filters: $filters,
                filtersShowMore: $filtersShowMore,
                maxFiltersDisplay: $maxFiltersDisplay,
                text: {
                    textFilterShowMore: $textFilterShowMore,
                    textFilterShowLess: $textFilterShowLess,
                    textFilterLabel: $textFilterLabel,
                    textUpcomingLabel: $textUpcomingLabel,
                    textPastLabel: $textPastLabel,
                    textClearAllLabel: $textClearAllLabel,
                    textShowNumberResults: $textShowNumberResults,
                    textPastLabelHeading: $textPastLabelHeading,
                    textUpcomingLabelHeading: $textUpcomingLabelHeading,
                    textPastNothingHere: $textPastNothingHere,
                    textUpcomingNothingHere: $textUpcomingNothingHere,
                }
            },
            state: {
                isOpenPopup: $isOpenPopup,
                list: $list,
                params: $params,
                totalPosts: $totalPosts,
                totalPages: $totalPages,
                filterShowMore: $isFilterShowMore,
                loaded: $isLoaded,
            }
        } = $this;

        return <div ref={$this.refPrincipalContainer}
                    className={`${!$isLoaded || $this.debugService ? 'fp-loading-container' : ''}`}>

            {($params.has('ftype') && $params.get('ftype') === 'past') &&
                <h3>{$textPastLabelHeading ?? 'Past Event'}</h3>}
            {(!$params.has('ftype') || $params.get('ftype') !== 'past') &&
                <h3>{$textUpcomingLabelHeading ?? 'Upcoming Event'}</h3>}

            {($params.has('ftype') && $params.get('ftype') === 'past') &&
                <a href="#" className="btn" onClick={$handleTypeEvent}>{$textUpcomingLabel ?? 'Upcoming Events'}</a>}

            {(!$params.has('ftype') || $params.get('ftype') !== 'past') &&
                <a href="#" className="btn" onClick={$handleTypeEvent}>{$textPastLabel ?? 'Past Events'}</a>}

            <a href="#" className="btn" onClick={($event) => $popup($event)}>{$textFilterLabel ?? 'filter '}<i
                className="icon icon-equalizer"></i></a>

            <>
                <div className={'active-filters'}>
                    {$RenderParams()}

                    {($hasParams()) && <a href="#" onClick={($event) => {
                        $event.preventDefault();
                        $clearAllFilter()
                    }} className="clear">Clear all</a>}
                </div>

                {$list.size > 0 && <>
                    <EventList events={$list}/>

                    {($isPagination && $totalPages > 0) &&
                        <Pagination config={{previous: "Previous", next: "Next", endSize: 2, midSize: 2}}
                                    totalPage={$totalPages} onClick={($page) => $onClick('page', $page)}
                                    page={$params.has('page') ? $params.get('page') : 1}/>}
                </>}

                {($this.loadedComponentDidMount && $list.size === 0) && <ContentNone
                    message={($params.has('ftype') && $params.get('ftype') === 'past') ? $textPastNothingHere : $textUpcomingNothingHere}
                />}

                {(!$isLoaded || $this.debugService) && <div className={"load-more-container dynamic-loading"}>
                    <div className={"fp-loading"}><span/><br/> Loading</div>
                </div>}
            </>

            <Popup isOpen={$isOpenPopup}>
                <Popup.Header>
                    <h2>Filters</h2>
                    <a className="close" href="#" onClick={($event) => $popup($event, true)}><i
                        className="icon icon-close"></i></a>
                </Popup.Header>
                <Popup.Body>
                    <div className={'active-filters'}>
                        {$RenderParams()}
                    </div>

                    {$filters && Object.entries($filters).map(({1: $filter}) => {
                        if (!$filter.element || (Object.entries($filter.choices).length < 1)) {
                            return false;
                        }
                        let $choices = $filter.choices.slice(0, $maxFiltersDisplay);

                        if ($isFilterShowMore.get($filter.key)) {
                            $choices = $filter.choices;
                        }

                        const Element = require(`../Design/${$filter.element}`).default;

                        return <>
                            <fieldset>
                                <legend>{$filter.label}</legend>
                                {$choices && $choices.map($choice => <Element name={$filter.key}
                                                                              type={$filter.type}
                                                                              value={$choice.value}
                                                                              label={$choice.label}
                                                                              checked={$params.has($filter.key) && $params.get($filter.key).has($choice.value)}
                                                                              onClick={$onClick}
                                />)}
                                {$filter.choices.length > $maxFiltersDisplay && <div>
                                    {($filters && $filtersShowMore && !$isFilterShowMore.get($filter.key)) &&
                                        <button type={"button"} className={'filter-show-more'}
                                                onClick={() => $filterShowMore($filter.key)}>{$textFilterShowMore}</button>}
                                    {($filters && $filtersShowMore && $isFilterShowMore.get($filter.key)) &&
                                        <button type={"button"} className={'filter-show-more'}
                                                onClick={() => $filterShowMore($filter.key)}>{$textFilterShowLess}</button>}
                                </div>}
                            </fieldset>
                        </>
                    })}
                </Popup.Body>
                <Popup.Footer>
                    <button className={"btn"}
                            onClick={() => $clearAllFilter()}>{$textClearAllLabel ?? 'clear all'}</button>
                    <button onClick={$popup} type={"button"}
                            className={"btn"}>{$textShowNumberResults ? $textShowNumberResults.replace('%countResults%', $totalPosts) : 'show (%countResults%) results'.replace('%countResults%', $totalPosts)}</button>
                </Popup.Footer>
            </Popup>
        </div>;
    }
}