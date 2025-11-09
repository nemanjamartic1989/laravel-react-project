export default function ConfirmationModal({ show, title, message, onConfirm, onCancel }) {
    if (!show) return null;

    return (
        <div className="modal-backdrop">
            <div className="modal-card">
                <h2 className="modal-title">{title}</h2>
                <p className="modal-message">{message}</p>
                <div className="modal-actions">
                    <button className="btn btn-confirm" onClick={onConfirm}>Yes</button>
                    <button className="btn btn-cancel" onClick={onCancel}>No</button>
                </div>
            </div>
        </div>
    );
}
