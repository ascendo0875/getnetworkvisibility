import PropTypes from "prop-types";
import React from "react";

export default class LoadMore extends DesignComponent {
    constructor(props) {
        super(props);

    }


    render() {
        const {dataKey, onClick} = this.props;

        return (
            <div className={"load-more-container"} key={`${dataKey}-loadmore`}>
                <p className="align-center">
                    <a href={'#'} className="btn" onClick={onClick}>
                        <span>
                            Load more
                        </span>
                    </a>
                </p>
            </div>
        );
    }

}

LoadMore.propTypes = {
    dataKey: PropTypes.string,
    onClick: PropTypes.func.isRequired,
}

LoadMore.defaultProps = {
    dataKey: Math.random().toString(),
    onClick: () => {},
}
