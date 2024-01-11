import React from 'react';
import PropTypes from "prop-types";

export default function ContentNone($props) {
    const {className: $className, message: $message} = $props;

    return <section className={`no-results not-found ${$className}`} dangerouslySetInnerHTML={{__html: $message}}>

    </section>
}

ContentNone.propTypes = {
    message: PropTypes.string.isRequired,
    className: PropTypes.string,
};

ContentNone.defaultProps = {
    className: '',
}