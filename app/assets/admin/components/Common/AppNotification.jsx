import CloseIcon from "@/images/shared/close.svg";
import AlertTriangleIcon from "@/images/shared/alert-triangle.svg";
import InfoCircleIcon from "@/images/shared/info-circle.svg";
import CheckIcon from "@/images/shared/check.svg";
import {useState} from "react";

const AppNotification = ({ label, variant }) => {
    const [isVisible, setIsVisible] = useState(true);

    const variants = {
        success: 'border-green-500',
        info: 'border-blue-500',
        warning: 'border-yellow-500',
        error: 'border-red-500'
    };

    const iconVariants = {
        success: <div className="bg-green-100 rounded-lg p-1"><CheckIcon className="text-green-500" /></div>,
        info: <div className="rounded-lg p-1 bg-blue-100"><InfoCircleIcon className="text-blue-500" /></div>,
        warning: <div className="rounded-lg p-1 bg-yellow-100"><AlertTriangleIcon className="text-yellow-500" /></div>,
        error: <div className="rounded-lg p-1 bg-red-100"><InfoCircleIcon className="text-red-500" /></div>
    }

    if (!isVisible) {
        return <></>
    }

    return (
        <div className="py-5">
            <div className={`flex items-center justify-between gap-3 w-full sm:max-w-[340px] rounded-md border-b-4 p-3 shadow-theme-sm bg-white  ${variants[variant]}`}>
                <div className="flex items-center gap-4">
                    {iconVariants[variant]}
                    <div>
                        <h4 className="font-medium text-gray-700">{label}</h4>
                    </div>
                </div>
                <CloseIcon className="text-gray-500 cursor-pointer" onClick={() => setIsVisible(false)} />
            </div>
        </div>
    );
};

export default AppNotification;
