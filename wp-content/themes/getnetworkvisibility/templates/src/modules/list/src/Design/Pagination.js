import PropTypes from "prop-types";

export default class Pagination extends React.Component {
    constructor(props) {
        super(props);

        this.changePage = this.changePage.bind(this);
        this.getSizePages = this.getSizePages.bind(this);

        this.pages = [];
    }

    changePage(event, page) {
        event.preventDefault();
        this.props.onClick(page);
    }

    getSizePages() {
        this.pages = [];

        const {props: {config: {endSize, midSize}, totalPage, page}, pages} = this;

        let dots = false;

        for (let p = 1; p <= totalPage; p++) {
            if (p === page) {
                pages[p] = [p, 'active'];
            } else {

                if ((p <= endSize) || (page && p >= (page - midSize) && p <= (page + midSize)) || (p > (totalPage - endSize))) {
                    pages[p] = [p, null];
                } else if ((!dots && p < page) || ((!dots && p > page && (p + 1) === totalPage) || (dots && (p + 1) === totalPage))) {
                    if (!dots) {
                        dots = p;
                    }

                    pages[p] = [p, 'dots'];
                }

            }
        }

        this.pages = pages;
    }

    render() {
        this.getSizePages();
        const {props: {config, totalPage, dataKey, page}, pages} = this;

        return (
            totalPage > 1 ? <div className={'pagination'} ref={`pagination-${dataKey}`}>
                <div className={'nav-links'}>
                    {(page - 1 > 0) && <a className="prev page-numbers" href="#" ref={`pagination-${dataKey}-previous`}
                                          onClick={event => this.changePage(event, (page - 1))}><span
                        className="screen-reader-text">{(config && config.previous) && config.previous}</span></a>}
                    {pages.map(p => (p[1] !== 'active' && p[1] !== 'dots') ?
                        [<a key={`pagination-${dataKey}-${p[0]}`} className="page-numbers" href="#"
                            onClick={event => this.changePage(event, p[0])}>
                            <span className="screen-reader-text">page </span>{p[0]}
                        </a>, ' \n'] : ((p[1] === 'active') ? [<span aria-current="page"
                                                                     className="page-numbers current"
                                                                     key={`pagination-${dataKey}-active-${p[0]}`}>
                    <span className="screen-reader-text">page </span>{p[0]}
                </span>, ' \n'] : [<span className={"page-numbers dots"}>...</span>, ' \n']))}
                    {page + 1 <= (totalPage) &&
                        <a className="next page-numbers" href="#" ref={`pagination-${dataKey}-next`}
                           onClick={event => this.changePage(event, (page + 1))}><span
                            className="screen-reader-text">{(config && config.next) && config.next}</span></a>}
                </div>
            </div> : null
        );
    }

}

Pagination.propTypes = {
    dataKey: PropTypes.string,
    onClick: PropTypes.func.isRequired,
    config: PropTypes.object,
    page: PropTypes.number.isRequired,
    totalPage: PropTypes.number.isRequired,
}

Pagination.defaultProps = {
    dataKey: Math.random().toString(),
    config: {previous: "Previous", next: "Next", midSize: 2, endSize: 1},
}
