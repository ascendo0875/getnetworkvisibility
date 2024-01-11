import React from "react";
import PropTypes from "prop-types";

export default class Input extends React.Component {
    constructor(props) {
        super(props);

        this.onChange = this.onChange.bind(this);
    }

    /**
     *
     * @param {HTMLElement} $event
     */
    onChange($event) {
        const $this = this;

        $this.props.onClick($event.target.name, $event.target.value);
    }

    render() {
        const {
            onChange: $onChange,
            props: {
                label: $label,
                type: $type,
                value: $value,
                name: $name,
                checked: $checked,
            }
        } = this;

        return <>
            <input
                id={`${$name}-${$value}`}
                type={$type}
                value={$value}
                name={$name}
                checked={$checked}
                onChange={$onChange}
            />
            {$label && <label htmlFor={`${$name}-${$value}`} key={`input-value-${$value}`} className={`${$checked ? 'active' : ''}`}>
                <span dangerouslySetInnerHTML={{__html: $label}}/>
            </label>}
        </>;
    }
}

Input.propTypes = {
    name: PropTypes.string,
    value: PropTypes.string,
    label: PropTypes.string,
    type: PropTypes.string,
    checked: PropTypes.bool,
    onClick: PropTypes.func
};

Input.defaultProps = {
    name: '',
    value: '',
    label: '',
    type: 'checkbox',
    checked: false,
    onClick: (value) => {
        console.log(value)
    }
}