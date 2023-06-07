import React, { useEffect } from "react";
import { useForm } from "react-hook-form";
import { Link } from "react-router-dom";
import "./index.css";
import { IMAGES } from "../../configurations/images";

function Login() {
    const {
        register,
        formState,
        reset,
        watch,
        getValues,
        formState: { errors, isSubmitSuccessful },
        handleSubmit,
    } = useForm();

    const onSubmit = (data) => {
        console.log(data);
    };

    useEffect(() => {
        if (formState.isSubmitSuccessful) {
            reset({
                password: "",
                password_repeat: "",
                name: "",
                email: "",
            });
        }
    }, [formState, reset]);

    return (
        <div className="signup">
            <img className="hide-bg image" src={IMAGES.amazonLogo} alt="logo" />
            <div className="form-border">
                <header>Sign in</header>
                <div className="form">
                    <form onSubmit={handleSubmit(onSubmit)}>
                        <label htmlFor="name">Mobile number or email</label>
                        <input
                            type="text"
                            name="email"
                            {...register("email", {
                                required: "Email is required",
                            })}
                            aria-invalid={errors.email ? "true" : "false"}
                        />
                        {errors.email && (
                            <p role="alert" className="text-error">
                                {errors.email?.message}
                            </p>
                        )}
                        <label htmlFor="password">Password</label>
                        <input
                            type="password"
                            name="password"
                            {...register(
                                "password",
                                { required: "password is required" },
                                { maxLength: 2 }
                            )}
                            aria-invalid={errors.password ? "true" : "false"}
                        />
                        {errors.password && (
                            <p role="alert" className="text-error">
                                {errors.password?.message}
                            </p>
                        )}
                        <button className="login-btn">Continue</button>
                    </form>
                    <p className="legal-info">
                        By creating an account, you agree to Amazon's{" "}
                        <a href="#">Conditions of Use</a> and{" "}
                        <a href="#">Privacy Notice</a>
                    </p>
                </div>

                <div className="login-divider">
                    <h5 className="new-to-amazon">New to Amazon?</h5>
                </div>

            </div>
                <div className="span-button">
                    <Link to="/admin/sign-up" className="text-button">
                        Create new Amazon account
                    </Link>
                </div>
        </div>
    );
}

export default Login;
