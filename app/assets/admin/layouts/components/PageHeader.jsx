import Heading from '@/admin/components/common/Heading';

const PageHeader = ({ title, children }) => {
    return (
        <div className="flex justify-between items-center mb-[2.5rem]">
            <Heading level="h3">{title}</Heading>
            <div>{children}</div>
        </div>
    );
};

export default PageHeader;
