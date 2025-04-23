import Card from '@/admin/components/Card';
import Heading from '@/admin/components/common/Heading';

const FormSidePanel = ({ sectionTitle, children }) => (
    <Card additionalClasses="w-[500px] h-full">
        <div className="flex flex-col gap-[1.5rem]">
            <Heading level="h3">{sectionTitle}</Heading>
            {children}
        </div>
    </Card>
);

export default FormSidePanel;
