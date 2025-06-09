import { useParams } from 'react-router-dom';

const useEntityId = (): { entityId: number | null; hasEntityId: boolean } => {
    const params = useParams<{ id?: string }>();
    const entityId = params.id && !isNaN(Number(params.id)) ? Number(params.id) : null;
    const hasEntityId = !!entityId;

    return { entityId, hasEntityId };
};

export default useEntityId;
