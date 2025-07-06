export default function Register() {
    const onSubmit = (e) => {
        e.preventDefault();
    }

    return (
        <div className="login-signup-form animated fadeInDown">
            <div className="form">
                <form onSubmit={onSubmit}>
                    <h1 className="form">
                        Sign Up for free
                    </h1>
                    <input type="name" placeholder="Full Name"/>
                    <input type="email" placeholder="Email"/>
                    <input type="password" placeholder="Password"/>
                    <input type="password_confirmation" placeholder="Password Confirmation"/>
                    <button className="btn btn-block">Sign Up</button>
                    <p classname="message">
                        Already Registered? <Link to="/login">Sign in</Link>
                    </p>
                </form>
            </div>
        </div>
    );
}