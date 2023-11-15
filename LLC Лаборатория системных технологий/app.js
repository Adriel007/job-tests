function serialize(numbers) {
    const maxNumber = Math.max(...numbers);
    const charSet = String.fromCharCode(...Array.from({ length: maxNumber }, (_, i) => i + 1));

    return numbers.map(number => charSet[number - 1]).join('');
}

function deserialize(serializedString) {
    const charSet = serializedString.split('');
    const charMap = new Map([...charSet.entries()].map(([index, char]) => [char, index + 1]));

    return charSet.map(char => charMap.get(char));
}

function runTest(testName, numbers) {
    const serialized = serialize(numbers);
    const deserialized = deserialize(serialized);
    const compressionRatio = serialized.length / (numbers.length * 2); // ASCII uses 2 bytes per character

    console.log(`Test: ${testName}`);
    console.log("Original:", numbers);
    console.log("Serialized:", serialized);
    console.log("Deserialized:", deserialized);
    console.log("Compression Ratio:", compressionRatio);
    console.log("------------------------");
}

// Tests
runTest("Simple Case", [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]);
runTest("Sequential 50", Array.from({ length: 50 }, (_, i) => i + 1));
runTest("Sequential 100", Array.from({ length: 100 }, (_, i) => i + 1));
runTest("Sequential 500", Array.from({ length: 500 }, (_, i) => i + 1));
runTest("Sequential 1000", Array.from({ length: 1000 }, (_, i) => i + 1));
runTest("Random 10", Array.from({ length: 10 }, (_, i) => Math.floor(Math.random() * 10) + 1));
runTest("Random 90", Array.from({ length: 10 }, (_, i) => Math.floor(Math.random() * 90) + 10));
runTest("Random 900", Array.from({ length: 10 }, (_, i) => Math.floor(Math.random() * 900) + 100));
runTest("Repeated 300", Array.from({ length: 300 }, (_, i) => i % 100 + 1));
