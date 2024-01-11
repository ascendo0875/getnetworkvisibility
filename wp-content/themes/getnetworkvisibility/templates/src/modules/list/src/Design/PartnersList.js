import PropTypes from "prop-types";

export default class PartnersList extends React.Component {
    constructor(props) {
        super(props);

    }

    render() {
        const $this = this;
        const {props: {resources: $resources}} = $this;

        return <section className={'partners-list is-style-search-results'}>
            {($resources.size > 0) && Array.from($resources).map(({1: $resource}) => <a href={$resource.permalink}
                                                                                        className={`partner ${($resource.cssClass) ? $resource.cssClass : ''}`}>
                <div className={'img'}>{$resource.image && <img src={$resource.image} width={165} height={31} alt={$resource.title}/>}</div>
                <div className={"blurb"}>
                    {$resource.title && <h4 dangerouslySetInnerHTML={{__html: $resource.title}}/>}
                    {$resource.excerpt && <p dangerouslySetInnerHTML={{__html: $resource.excerpt}}/>}
                </div>
            </a>)}
        </section>;
    }
}

PartnersList.propTypes = {
    resources: PropTypes.instanceOf(Map).isRequired,
}

PartnersList.defaultProps = {
    resources: new Map,
}
