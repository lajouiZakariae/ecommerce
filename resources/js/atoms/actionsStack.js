import { atomWithReducer } from "jotai/utils";

export default atomWithReducer(
    { redos: [], undos: [] },

    (prev, { type, payload }) => {
        if (type === "ADD_ACTION") {
            return {
                redos: prev.redos.length ? [] : [...prev.redos],
                undos: [...prev.undos, payload],
            };
        }

        if (type === "UNDO") {
            const newUndos = prev.undos.slice(0, prev.undos.length - 1);
            const action = prev.undos.pop();
            console.log(action.undo);
            action.undo();
            return {
                undos: newUndos,
                redos: [...prev.redos, action],
            };
        }

        if (type === "REDO") {
            return {
                redos: prev.redos.slice(0, prev.redos.length - 1),
                undos: [...prev.undos, prev.redos.pop()],
            };
        }

        return prev;
    }
);
