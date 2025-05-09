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
        info: 'bg-info text-black',
        success: 'bg-success text-black',
        error: 'bg-error text-black',
        warning: 'bg-warning text-black',
    };

    const iconVariants = {
        success: (
            <div className="rounded-lg">
                <CheckIcon className="text-green-500 w-[24px] h-[24px]" />
            </div>
        ),
        info: (
            <div className="rounded-lg">
                <InfoCircleIcon className="text-blue-500 w-[24px] h-[24px]" />
            </div>
        ),
        warning: (
            <div className="rounded-lg">
                <AlertTriangleIcon className="text-yellow-500 w-[24px] h-[24px]" />
            </div>
        ),
        error: (
            <div className="rounded-lg">
                <InfoCircleIcon className="text-red-500 w-[24px] h-[24px]" />
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
