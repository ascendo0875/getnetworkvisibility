import PropTypes from "prop-types";

export default class ResourceList extends React.Component {
    constructor(props) {
        super(props);

    }

    render() {
        const $this = this;
        const {props: {resources: $resources, className: $className}} = $this;

        return <section className={`resources-list ${$className}`}>
            {($resources.size > 0) && Array.from($resources).map(({1: $resource}) => <a href={$resource.permalink}
                                                                                        className={`article ${($resource.cssClass) ? $resource.cssClass : ''}`}>
                <div className={"blurb"}>
                    {$resource.topics && <p className={'heading-5 is-style-blue'} dangerouslySetInnerHTML={{__html: $resource.topics}}/>}
                    {$resource.categories && <h5 className={'is-style-blue'} dangerouslySetInnerHTML={{__html: $resource.categories}}/>}
                    {$resource.title && <h3 dangerouslySetInnerHTML={{__html: $resource.title}}/>}
                    {$resource.excerpt && <p dangerouslySetInnerHTML={{__html: $resource.excerpt}}/>}
                </div>

                {$resource.image && <div className={'img'} style={{backgroundImage: `url(${$resource.image})`}}/>}
            </a>)}
        </section>;
    }
}

ResourceList.propTypes = {
    resources: PropTypes.instanceOf(Map).isRequired,
    className: PropTypes.string,
}

ResourceList.defaultProps = {
    resources: new Map,
    className: '',
}
