import React from 'react';
import Card from '@/admin/components/Card';
import RegisterForm from '@/admin/features/auth/components/RegisterForm';

const Register = () => {
    return (
        <div className="container mx-auto py-8">
            <Card additionalClasses="max-w-md mx-auto shadow-lg">
                <h1 className="text-2xl font-bold py-5 mb-6 text-center ">Zarejestruj się</h1>
                <RegisterForm />
            </Card>
        </div>
    );
};

export default Register;
