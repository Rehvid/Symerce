import React, {useState} from 'react';
import { useNavigate } from 'react-router-dom';
import LoginForm from './Partials/LoginForm';
import { createApiConfig } from '../../../shared/api/ApiConfig';
import {useAuth} from "@/admin/hooks/useAuth";
import {useApi} from "@/admin/hooks/useApi";
import Card from "@/admin/components/Card";

const LoginPage = () => {
    const [validationErrors, setValidationErrors] = useState({});
    const navigate = useNavigate();
    const { login } = useAuth();
    const { executeRequest } = useApi();
    const apiConfig = createApiConfig('login_check', 'POST', false);

    const onSubmit = async values => {
        try {
            const result = await executeRequest(apiConfig, values);
            const { data, errors } = result;

            if (data) {
                login(data);
                navigate('/admin/dashboard');
            }

            if (errors) {
                setValidationErrors(errors);
            }
        } catch (e) {
            console.error('Unexpected error', e.message);
        }
    };

    return (
        <div className="container mx-auto my-auto py-8">
            <Card additionalClasses="max-w-md mx-auto shadow-lg">
                <h1 className="text-2xl font-bold py-5 mb-6 text-center ">Zaloguj się</h1>
                <LoginForm onSubmit={onSubmit} validationErrors={validationErrors} />
            </Card>
        </div>
    );
};

export default LoginPage;
