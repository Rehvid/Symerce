import ModalHeader from '@admin/common/components/modal/ModalHeader';
import ModalBody from '@admin/common/components/form/ModalBody';

interface ModalFileProps {
    name: string;
    preview: string;
}

const ModalFile: React.FC<ModalFileProps> = ({ name, preview }) => (
    <>
        <ModalHeader title={name} />
        <ModalBody>
            <div className="border border-gray-200 shadow-xl rounded-lg h-full overflow-auto">
                <img className="rounded-lg h-auto max-w-xl" src={preview} alt={name} />
            </div>
        </ModalBody>
    </>
);

export default ModalFile;
