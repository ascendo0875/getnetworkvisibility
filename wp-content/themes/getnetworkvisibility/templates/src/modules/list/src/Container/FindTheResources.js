import ListComponent from "../Service/ListComponent";
import Popup from "../Design/Popup";

export default class FindTheResources extends ListComponent {
    constructor(props) {
        super(props);

        this.state = {
            ...this.state,
            isOpenPopup: false,
            showMore: false
        };

        this.popup = this.popup.bind(this);
        this.searchBy = this.searchBy.bind(this);
        this.onClick = this.onClick.bind(this);
        this.onShowMore = this.onShowMore.bind(this);
        this.onSubmitForm = this.onSubmitForm.bind(this);
        this.onRedirectSearch = this.onRedirectSearch.bind(this);
    }

    componentDidMount() {
        super.componentDidMount();

        const $this = this;

        document.addEventListener('keyup', function ($event) {
            $event.preventDefault();

            if ($event.keyCode === 13 && $this.state.params.size > 0) {
                console.info($event);
                $this.onRedirectSearch();
            }
        });
    }

    popup() {
        const $this = this;
        const {state: {isOpenPopup: $isOpenPopup}} = $this;

        if ($isOpenPopup) {
            $this.clearAllFilter();
            this.addPublishEvents('fp.closePopup');
        } else {
            this.addPublishEvents('fp.openPopup');
        }

        $this.setState({isOpenPopup: !$isOpenPopup}, () => {
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

    getList() {
        return false
    }

    searchBy($event) {
        const $this = this;
        const {config: {redirectToSearch: $redirectToSearch}, state: {params: $params}} = $this;
        const $value = $event.target.value;

        $this.setParamsValue($params, $this.searchKey, $value);
        $this.setState({params: $params});
    }

    setParamsValue($params, $key, $value) {
        const $this = this;

        switch ($key) {
            case $this.searchKey:
                $params.clear();

                if ($value) {
                    $params.set($key, $value);
                }
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

    onShowMore() {
        const $this = this;

        $this.setState({showMore: !$this.state.showMore});
    }

    onSubmitForm($event) {
        $event.preventDefault();
        const $this = this;
        $this.onRedirectSearch();
    }

    onRedirectSearch() {
        const $this = this;

        $this.UrlManager.$params = $this.state.params;
        $this.UrlManager.pushState($this.config.redirectToSearch);
    }

    render() {
        const $this = this;
        const {
            popup: $popup,
            clearAllFilter: $clearAllFilter,
            searchBy: $searchBy,
            searchKey: $searchKey,
            onClick: $onClick,
            onShowMore: $onShowMore,
            onSubmitForm: $onSubmitForm,
            renderParams: $RenderParams,
            onRedirectSearch: $onRedirectSearch,
            config: {
                redirectToSearch: $redirectToSearch,
                filters: $filters,
                text: {
                    popupTitle: $popupTitle,
                    buttonLabelFindTheResources: $buttonLabelFindTheResources,
                    textShowMore: $textShowMore,
                    textShowLess: $textShowLess,
                    textSearchLabel: $textSearchLabel,
                    textLabelClearAll: $textLabelClearAll,
                    textLabelFindResources: $textLabelFindResources,
                }
            },
            state: {
                isOpenPopup: $isOpenPopup,
                params: $params,
                showMore: $showMore,
            }
        } = $this;

        return <div ref={$this.refPrincipalContainer}>
            <button className={'find-the-resources is-style-solid'} onClick={$popup}
                    type={"button"}>{$buttonLabelFindTheResources}</button>
            <Popup isOpen={$isOpenPopup} className={'find-the-resources'}>
                <Popup.Header>
                    <h2>{$popupTitle}</h2>
                    <a className="close" href="#" onClick={($event) => $popup($event, true)}><i
                        className="icon icon-close"></i></a>
                </Popup.Header>
                <Popup.Body>
                    <div className={'active-filters'}>
                        {$RenderParams()}
                    </div>

                    <h3 className={'is-style-gradient'}>Find the resources you need</h3>
                    <p>Tell us an issue you’re having, topic you’re interested in or select from the list below:</p>
                    <form onSubmit={($event) => $onSubmitForm($event)}>
                        {(($params.size > 0 && $params.has($searchKey)) || ($params.size === 0)) &&
                            <div className="search-area">
                                <input type="search" placeholder={$textSearchLabel}
                                       defaultValue={$params.has($searchKey) ? $params.get($searchKey) : ''}
                                       ref={($ref) => $this.searchRef = $ref}
                                       onChange={$searchBy}/>
                                <button type={'submit'} className={'submit-button'}><i
                                    className="icon icon-arrow-right"></i>
                                </button>
                            </div>}

                        {($filters && ($params.size === 0 || !$params.has($searchKey))) && <>
                            {Object.entries($filters).map(({1: $filter}) => {
                                if ((!$showMore && !$filter.isVisible) || !$filter.element || (Object.entries($filter.choices).length < 1)) {
                                    return false;
                                }

                                let $choices = $filter.choices;

                                if (!$showMore) {
                                    $choices = $choices.slice(0, 4);
                                }

                                const Element = require(`../Design/${$filter.element}`).default;

                                return <>
                                    <fieldset>
                                        {$filter.label && <legend>{$filter.label}</legend>}
                                        {$choices && $choices.map($choice => <Element name={$filter.key}
                                                                                      type={$filter.type}
                                                                                      value={$choice.value}
                                                                                      label={$choice.label}
                                                                                      checked={$params.has($filter.key) && $params.get($filter.key).has($choice.value)}
                                                                                      onClick={$onClick}
                                        />)}
                                    </fieldset>
                                </>
                            })}
                            {!$showMore &&
                                <button className={'show-more'} type={"button"}
                                        onClick={$onShowMore}>{$textShowMore}</button>}
                            {$showMore &&
                                <button className={'show-less'} type={"button"}
                                        onClick={$onShowMore}>{$textShowLess}</button>}
                        </>}
                    </form>
                </Popup.Body>
                <Popup.Footer>
                    <button className={"btn"}
                            onClick={() => $clearAllFilter()}>{$textLabelClearAll ?? 'clear all'}</button>

                    <button onClick={$onRedirectSearch} type={"button"} disabled={($params.size === 0)}
                            className={"btn"}>{$textLabelFindResources}</button>
                </Popup.Footer>
            </Popup>
        </div>;
    }
}