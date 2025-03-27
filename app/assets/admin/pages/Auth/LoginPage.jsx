import React from 'react';
import { useNavigate } from 'react-router-dom';
import { useAuth } from '../../context/AuthContext';
import RestApiClient from '../../../shared/api/RestApiClient';
import LoginForm from "./Partials/LoginForm";
import {createApiConfig} from "../../../shared/api/ApiConfig";

const LoginPage = () => {
    const navigate = useNavigate();
    const { login } = useAuth();
    const apiConfig = createApiConfig('login_check', 'POST', false);

    const onSubmit = async values => {
        try {
            const result = await RestApiClient().executeRequest(apiConfig, values);
            const {data} = result;

            if (data.user) {
                login(data.user);
                navigate('/admin/dashboard');
            }
        } catch (e) {
            console.error('Unexpected error', e.message);
        }
    };

    return (
        <div className="container mx-auto py-8">
            <h1 className="text-2xl font-bold mb-6 text-center">Zaloguj się</h1>
            <LoginForm onSubmit={onSubmit} />
        </div>
    );
}

export default LoginPage;
