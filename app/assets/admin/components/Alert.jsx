import React from 'react';
import CheckIcon from '@/images/icons/check.svg';
import InfoCircleIcon from '@/images/icons/info-circle.svg';
import AlertTriangleIcon from '@/images/icons/alert-triangle.svg';
import { isValidEnumValue } from '@/admin/utils/helper';
import { ALERT_TYPES } from '@/admin/constants/alertConstants';

const Alert = ({ message, variant }) => {
    if (!isValidEnumValue(ALERT_TYPES, variant)) {
        return null;
    }

    const variants = {
        success: 'bg-green-100 text-green-500',
        info: 'bg-blue-100 text-blue-500',
        warning: 'bg-yellow-100 text-yellow-500',
        error: 'bg-red-100 text-red-500',
    };

    const iconVariants = {
        success: (
            <div className="rounded-lg">
                <CheckIcon className="text-green-500" />
            </div>
        ),
        info: (
            <div className="rounded-lg">
                <InfoCircleIcon className="text-blue-500" />
            </div>
        ),
        warning: (
            <div className="rounded-lg">
                <AlertTriangleIcon className="text-yellow-500" />
            </div>
        ),
        error: (
            <div className="rounded-lg">
                <InfoCircleIcon className="text-red-500" />
            </div>
        ),
    };

    return (
        <div className={`mb-6 p-3 rounded-lg ${variants[variant]}`}>
            <div className="flex items-center gap-4 w-full">
                {iconVariants[variant]}
                <span className="font-medium">{message}</span>
            </div>
        </div>
    );
};

export default Alert;
