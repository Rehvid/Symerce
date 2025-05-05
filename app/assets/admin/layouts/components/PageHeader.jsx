import Heading from '@/admin/components/common/Heading';

const PageHeader = ({ title, children }) => {
    return (
        <div className="flex justify-between flex-wrap items-center mb-[1.5rem] gap-4">
            <Heading level="h2">{title}</Heading>
            <div className="w-full sm:w-auto">{children}</div>
        </div>
    );
};

export default PageHeader;
