import java.io.IOException;
import java.util.HashMap;

import javax.sound.midi.InvalidMidiDataException;
import javax.sound.midi.MetaEventListener;
import javax.sound.midi.MetaMessage;
import javax.sound.midi.MidiSystem;
import javax.sound.midi.MidiUnavailableException;
import javax.sound.midi.Receiver;
import javax.sound.midi.Sequence;
import javax.sound.midi.Sequencer;
import javax.sound.midi.Synthesizer;
import javax.sound.midi.Transmitter;

/*
 * Created on 2006/11/05
 */

public class MidiEngine implements MetaEventListener {
    // �Đ��I�����^�C�x���g
    private static final int END_OF_TRACK = 47;

    // �V�[�P���T�[
    private Sequencer sequencer;
    // �V���Z�T�C�U�[
    private Synthesizer synthesizer;

    // �o�^�ł���MIDI�t�@�C���̍ő吔
    private int maxSequences;
    // MIDI�t�@�C���f�[�^�i���O->Sequence�j
    private HashMap midiMap;
    // �o�^����Ă���MIDI�t�@�C����
    private int counter = 0;

    // ���ݍĐ�����MIDI�V�[�P���X��
    String currentSequenceName = "";

    /**
     * �R���X�g���N�^
     */
    public MidiEngine() {
        this(256);
    }

    /**
     * �R���X�g���N�^
     * 
     * @param maxSequences
     *            �o�^�ł���MIDI�t�@�C���̍ő吔
     */
    public MidiEngine(int maxSequences) {
        this.maxSequences = maxSequences;
        midiMap = new HashMap(maxSequences);

        // �V�[�P���T�[�ƃV���Z�T�C�U�[��������
        initSequencer();
    }

    private void initSequencer() {
        try {
            // �V�[�P���T���J��
            sequencer = MidiSystem.getSequencer();
            sequencer.open();
            // ���^�C�x���g���X�i�[��o�^
            sequencer.addMetaEventListener(this);
            // �V�[�P���T�ƃV���Z�T�C�U�[�̐ڑ�
            if (!(sequencer instanceof Synthesizer)) { // J2SE 5.0�p
                // �V���Z�T�C�U�[���J��
                synthesizer = MidiSystem.getSynthesizer();
                synthesizer.open();
                Receiver synthReceiver = synthesizer.getReceiver();
                Transmitter seqTransmitter = sequencer.getTransmitter();
                seqTransmitter.setReceiver(synthReceiver);
            } else { // J2SE 1.4.2�ȑO
                // �V�[�P���T�ƃV���Z�T�C�U�[�͓���
                synthesizer = (Synthesizer) sequencer;
            }
        } catch (MidiUnavailableException e) {
            e.printStackTrace();
        }
    }

    /**
     * MIDI�t�@�C�������[�h
     * 
     * @param name
     *            �o�^��
     * @param filename
     *            �t�@�C����
     */
    public void load(String name, String filename) {
        if (counter == maxSequences) {
            System.out.println("�G���[: ����ȏ�o�^�ł��܂���");
            return;
        }

        try {
            // MIDI�t�@�C�������[�h
            Sequence seq = MidiSystem.getSequence(getClass().getResource(
                    filename));
            // �o�^
            midiMap.put(name, seq);
        } catch (InvalidMidiDataException e) {
            e.printStackTrace();
        } catch (IOException e) {
            e.printStackTrace();
        }
    }

    /**
     * �Đ�
     * 
     * @param name
     *            �o�^��
     */
    public void play(String name) {
        // ���ݍĐ����̃V�[�P���X�Ɠ����Ȃ牽�����Ȃ�
        if (currentSequenceName.equals(name)) {
            return;
        }

        // ���ݍĐ����̃V�[�P���X���~����
        stop();

        // ���O�ɑΉ�����MIDI���擾
        Sequence seq = (Sequence)midiMap.get(name);  // MIDI�V�[�P���X
        if (sequencer != null && seq != null) {
            try {
                sequencer.setSequence(seq);  // �V�[�P���T�ɃZ�b�g
                sequencer.start();  // �Đ��J�n�I
                currentSequenceName = name;
            } catch (InvalidMidiDataException e) {
                e.printStackTrace();
            }
        }
    }

    /**
     * ��~
     */
    public void stop() {
        if (sequencer.isRunning()) {
            sequencer.stop();
        }
    }

    /**
     * �I������
     */
    public void close() {
        // �Đ����̃V�[�P���X���~����
        stop();

        // �V�[�P���T�̏I������
        sequencer.removeMetaEventListener(this);
        sequencer.close();
        sequencer = null;
    }

    public void meta(MetaMessage meta) {
        // �Đ����I�������ꍇ
        if (meta.getType() == END_OF_TRACK) {
            if (sequencer != null && sequencer.isOpen()) {
                // MIDI�V�[�P���X�Đ��ʒu�ɖ߂�
                sequencer.setMicrosecondPosition(0);
                // �ŏ�����Đ�
                sequencer.start();
            }
        }
    }
}
