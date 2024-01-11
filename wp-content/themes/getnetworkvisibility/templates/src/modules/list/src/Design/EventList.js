import PropTypes from "prop-types";

export default class EventList extends React.Component {
    constructor(props) {
        super(props);

    }

    render() {
        const $this = this;
        const {props: {events: $events, className: $className}} = $this;

        return <section className={`events-list articles-list stacked  ${$className}`}>
            {($events.size > 0) && Array.from($events).map(({1: $event}) => <div className={$event.cssClass ?? ''}>
                <div className={`article-body`}>
                <div className={"blurb"}>
                    {$event.date && <p className={'date'}>{$event.date}</p>}
                    {$event.location && <p className={'location'} dangerouslySetInnerHTML={{__html: $event.location.join('<br/>')}}/>}
                    {($event.title && !$event.dontLinkToDetailPage) && <h3><a href={$event.permalink} dangerouslySetInnerHTML={{__html: $event.title}}/></h3>}
                    {($event.title && $event.dontLinkToDetailPage) && <h3 dangerouslySetInnerHTML={{__html: $event.title}}/>}
                    {$event.excerpt && <p dangerouslySetInnerHTML={{__html: $event.excerpt}}/>}
                    {!$event.dontLinkToDetailPage && <p className={'more-link'}>
                        <a href={$event.permalink}>Learn More</a>
                        {$event.registerPage && <a className={'btn'} href={$event.registerPage} target={$event.registerPageTarget}>{$event.registerPageLabel ? $event.registerPageLabel : 'Register Now'}</a>}
                    </p>}
                </div>

                {($event.image && !$event.dontLinkToDetailPage) && <a href={$event.permalink} className={'img'} style={{backgroundImage: `url(${$event.image})`}}/>}
                {($event.image && $event.dontLinkToDetailPage) && <div className={'img'} style={{backgroundImage: `url(${$event.image})`}}/>}
            </div>
            </div>)}
        </section>;
    }
}

EventList.propTypes = {
    events: PropTypes.instanceOf(Map).isRequired,
    className: PropTypes.string,
}

EventList.defaultProps = {
    events: new Map,
    className: '',
}
