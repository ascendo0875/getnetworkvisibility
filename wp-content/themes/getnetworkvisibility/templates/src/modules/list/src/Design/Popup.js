import PropTypes from "prop-types";

export default class Popup extends React.Component {
    constructor(props) {
        super(props);

        this.state = {
            isOpen: props.isOpen,
        }

        this.animation = this.animation.bind(this);

        this.delayInPopup = this.props.delayInPopup;
        this.delayOutPopup = this.props.delayOutPopup;

        this.popupRef = React.createRef();
        this.popupOverlayRef = React.createRef();

        this.nodePopup = false;
    }

    componentWillReceiveProps(nextProps, nextContext) {
        if (nextProps.isOpen !== this.state.isOpen) {
            const $this = this;

            if(nextProps.isOpen && !$this.nodePopup) {
                $this.nodePopup = document.createElement('div');
                $this.nodePopup.className = 'popup-container';
            }

            if(nextProps.isOpen) {
                document.body.append($this.nodePopup);
            }

            if (nextProps.isOpen) {
                $this.setState({isOpen: nextProps.isOpen}, () => {
                    setTimeout(() => $this.animation(nextProps.isOpen), $this.delayInPopup);
                })
            } else {
                $this.animation(nextProps.isOpen);

                setTimeout(() => {
                    $this.setState({isOpen: nextProps.isOpen});
                    $this.nodePopup.remove();
                }, $this.delayOutPopup);
            }
        }
    }

    animation($isOpen = false) {
        const $this = this;

        if ($isOpen) {

            if (this.popupRef && this.popupRef.current) {
                $this.popupRef.current.style.opacity = '1';
                $this.popupRef.current.style.top = '90px';
                $this.popupRef.current.style.pointerEvents = 'auto';
            }
            if ($this.popupOverlayRef.current) {
                $this.popupOverlayRef.current.style.opacity = '1';
                $this.popupRef.current.style.pointerEvents = 'auto';
            }
        } else {
            if (this.popupRef && this.popupRef.current) {
                $this.popupRef.current.style.opacity = '0';
                $this.popupRef.current.style.top = '0';
                $this.popupRef.current.style.pointerEvents = 'none';
            }
            if (this.popupOverlayRef && this.popupOverlayRef.current) {
                $this.popupOverlayRef.current.style.opacity = '0';
                $this.popupRef.current.style.pointerEvents = 'none';
            }
        }
    }

    render() {
        const $this = this;
        const {
            state: {isOpen: $displayPopup},
            props: {children: $children, className: $className},
        } = $this;

        return <>
            {($displayPopup && $this.nodePopup) &&
                ReactDOM.createPortal(<>
                    <div className={`popup-overlay`} ref={$this.popupOverlayRef}></div>
                    <section className={`popup ${$className}`} ref={$this.popupRef}>
                        {$children}
                    </section>
                </>, $this.nodePopup)
            }
        </>;
    }
}

Popup.propTypes = {
    isOpen: PropTypes.bool.isRequired,
    className: PropTypes.string,
    delayInPopup: PropTypes.number,
    delayOutPopup: PropTypes.number,
}

Popup.defaultProps = {
    isOpen: false,
    className: '',
    delayInPopup: 1,
    delayOutPopup: 600,
}

class Header extends React.Component {
    constructor(props) {
        super(props);

    }

    render() {
        const {props: {children: $children}} = this;

        return <div className={'popup-header'}>
            {$children}
        </div>;
    }
}

class Body extends React.Component {
    constructor(props) {
        super(props);

    }

    render() {
        const {props: {children: $children}} = this;

        return <div className={'popup-body'}>
            {$children}
        </div>;
    }
}

class Footer extends React.Component {
    constructor(props) {
        super(props);

    }

    render() {
        const {props: {children: $children}} = this;

        return <div className={'popup-footer'}>
            {$children}
        </div>;
    }
}

Popup.Header = Header;
Popup.Body = Body;
Popup.Footer = Footer;