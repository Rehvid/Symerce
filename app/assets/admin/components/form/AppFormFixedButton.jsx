import AppButton from '@/admin/components/common/AppButton';

const AppFormFixedButton = ({ children }) => (
    <div className="fixed bottom-0 left-0 right-0 z-10 mt-8 bg-white -mx-8 py-4 rounded-md">
        <div className="container mx-auto">
            <div className="flex items-center justify-end">
                {children}
                <AppButton variant="primary" type="submit" additionalClasses="px-5 py-3">
                    Zapisz
                </AppButton>
            </div>
        </div>
    </div>
);

export default AppFormFixedButton;
