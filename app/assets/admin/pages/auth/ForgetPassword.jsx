import Card from '@/admin/components/Card';
import Alert from '@/admin/components/Alert';
import React, { useState } from 'react';
import ForgotPasswordForm from '@/admin/features/auth/components/ForgetPasswordForm';

const ForgetPassword = () => {
    return (
        <div className="container mx-auto my-auto py-8">
            <Card additionalClasses="max-w-md mx-auto shadow-lg">
                <h1 className="text-2xl font-bold py-5 mb-6 text-center ">Przypomnij hasło</h1>
                <ForgotPasswordForm />
            </Card>
        </div>
    );
};

export default ForgetPassword;
