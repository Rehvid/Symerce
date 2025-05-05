import AppButton from '@/admin/components/common/AppButton';
import { useNavigate } from 'react-router-dom';
import ArrowLeftIcon from '@/images/icons/arrow-left.svg';
import SaveIcon from '@/images/icons/device-floppy.svg';

const FormFooterActions = ({ children }) => {
    const navigate = useNavigate();
    return (
        <div className="fixed bottom-0 left-0 right-0 z-10 mt-8 bg-white py-4 rounded-md border-t  border-gray-300">
            <div className="ml-[290px]">
                <div className="flex items-center justify-end pr-[48px] gap-5">
                    {children}
                    <AppButton
                        variant="secondary"
                        type="button"
                        additionalClasses="px-5 py-3 flex gap-2"
                        onClick={() => {
                            navigate(-1);
                        }}
                    >
                        <ArrowLeftIcon />
                        Wstecz
                    </AppButton>
                    <AppButton variant="primary" type="submit" additionalClasses="px-5 py-3 flex gap-2">
                        <SaveIcon />
                        Zapisz
                    </AppButton>
                </div>
            </div>
        </div>
    );
};

export default FormFooterActions;
