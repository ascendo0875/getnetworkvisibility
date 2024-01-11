import ListComponent from "../Service/ListComponent";
import Popup from "../Design/Popup";
import ResourceList from "../Design/ResourceList";
import Pagination from "../Design/Pagination";

export default class Resources extends ListComponent {
    constructor(props) {
        super(props);

        this.state = {
            ...this.state,
            isOpenPopup: false,
            filterShowMore: new Map,
        };

        this.isSubmitForm = false;

        this.popup = this.popup.bind(this);
        this.onClick = this.onClick.bind(this);
        this.filterShowMore = this.filterShowMore.bind(this);
        this.renderParams = this.renderParams.bind(this);
        this.onSubmitForm = this.onSubmitForm.bind(this);
        this.forceRedirect = this.forceRedirect.bind(this);
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

    /**
     *
     * @param {FormDataEvent} $event
     */
    onSubmitForm($event) {
        $event.preventDefault();
        const $this = this;
        $this.isSubmitForm = true;

        $this.forceRedirect();
    }

    forceRedirect() {
        const $this = this;
        const {config: {redirectToSearch: $redirectToSearch}} = $this;

        setTimeout(async () => {
            if ($redirectToSearch && $this.isSubmitForm) {
                $this.UrlManager.pushState($redirectToSearch);
            }
        }, 500);
    }

    searchBy($event) {
        const $this = this;
        const {config: {redirectToSearch: $redirectToSearch}, state: {params: $params}} = $this;
        const $value = $event.target.value;

        if ($redirectToSearch) {
            $this.setParamsValue($params, $this.searchKey, $value);
        } else {
            super.searchBy($event);
        }
    }

    render() {
        const $this = this;
        const {
            popup: $popup,
            onClick: $onClick,
            clearAllFilter: $clearAllFilter,
            searchBy: $searchBy,
            filterShowMore: $filterShowMore,
            renderParams: $RenderParams,
            onSubmitForm: $onSubmitForm,
            hasParams: $hasParams,
            searchKey: $searchKey,
            isPagination: $isPagination,
            config: {
                redirectToSearch: $redirectToSearch,
                filters: $filters,
                filtersShowMore: $filtersShowMore,
                maxFiltersDisplay: $maxFiltersDisplay,
                text: {
                    textFilterShowMore: $textFilterShowMore,
                    textFilterShowLess: $textFilterShowLess,
                    textSearchLabel: $textSearchLabel,
                    textButtonSearchLabel: $textButtonSearchLabel,
                    textFilterLabel: $textFilterLabel,
                    textClearAllLabel: $textClearAllLabel,
                    textShowNumberResults: $textShowNumberResults,
                    copyMessage: $copyMessage,
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

        return <div ref={$this.refPrincipalContainer} className={`${!$isLoaded || $this.debugService ? 'fp-loading-container' : ''}`}>
            <form action={$redirectToSearch ?? ''} onSubmit={($event) => $onSubmitForm($event)}>
                <div className={'search-area'}>
                    <input type={"search"} placeholder={$textSearchLabel ?? 'type a keyword'}
                           ref={($ref) => $this.searchRef = $ref}
                           defaultValue={$params.has($searchKey) ? $params.get($searchKey) : ''} onChange={$searchBy}/>
                    <button type={"submit"}>
                        {$textButtonSearchLabel ?? 'search'}
                    </button>
                </div>

                <a href="#" className="btn" onClick={($event) => $popup($event)}>{$textFilterLabel ?? 'filter '}</a>
            </form>

            {(!$redirectToSearch) && <>
                <div className={'active-filters'}>
                    {$RenderParams()}

                    {($hasParams()) && <a href="#" onClick={($event) => {
                        $event.preventDefault();
                        $clearAllFilter()
                    }} className="clear">Clear all</a>}
                </div>

                <ResourceList resources={$list}/>

                {($isPagination && $totalPages > 0) &&
                    <Pagination config={{previous: "Previous", next: "Next", endSize: 2, midSize: 2}}
                                totalPage={$totalPages} onClick={($page) => $onClick('page', $page)}
                                page={$params.has('page') ? $params.get('page') : 1}/>}

                {(!$isLoaded || $this.debugService) && <div className={"load-more-container dynamic-loading"}>
                    <div className={"fp-loading"}><span/><br/> Loading</div>
                </div>}
            </>}

            {$copyMessage && <div className={'copy-content'} dangerouslySetInnerHTML={{__html: $copyMessage}}></div>}

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