import Card from '@/admin/components/Card';
import Heading from '@/admin/components/common/Heading';

const FormSidePanel = ({ sectionTitle, children }) => (
    <Card additionalClasses="xl:w-[400px] w-full h-full">
        <div className="flex flex-col gap-[1.5rem]">
            <Heading level="h3">{sectionTitle}</Heading>
            {children}
        </div>
    </Card>
);

export default FormSidePanel;
